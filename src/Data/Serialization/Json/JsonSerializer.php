<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization\Json;

use CodeKandis\JsonCodec\JsonDecoder;
use CodeKandis\JsonCodec\JsonEncoder;
use CodeKandis\JsonCodec\JsonEncoderOptions;
use CodeKandis\Pharty\Annotations\AnnotationReaderInstantiationFailedException;
use CodeKandis\Pharty\Data\Serialization\DeserializationFailedException;
use CodeKandis\Pharty\Data\Serialization\NotASerializationContractException;
use CodeKandis\Pharty\Data\Serialization\ParsedSerializationProperty;
use CodeKandis\Pharty\Data\Serialization\SerializationContractHasNoPropertiesException;
use CodeKandis\Pharty\Data\Serialization\SerializationContractHasTooMuchPropertiesException;
use CodeKandis\Pharty\Data\Serialization\SerializationContractNotFoundException;
use CodeKandis\Pharty\Data\Serialization\SerializationContractParser;
use CodeKandis\Pharty\Data\Serialization\SerializationFailedException;
use JsonException;
use stdClass;
use function array_filter;
use function array_keys;
use function count;
use function get_class;
use function is_array;
use function is_object;

/**
 * Represents the interface of all JSON serializers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class JsonSerializer implements JsonSerializerInterface
{
	/**
	 * Represents the error message if a serialization failed.
	 * @var string
	 */
	protected const ERROR_SERIALIZATION_FAILED = 'The serialization failed.';

	/**
	 * Represents the error message if a deserialization failed.
	 * @var string
	 */
	protected const ERROR_DESERIALIZATION_FAILED = 'The deserialization failed.';

	/**
	 * Determines if an array is an associative array.
	 * @param array $data The array to determine if it is an associative array.
	 * @return bool True if the array is an associative array, false otherwise.
	 */
	private function isAssociativeArray( array $data ): bool
	{
		return 0 < count(
				array_filter(
					array_keys( $data ),
					'\is_string'
				)
			);
	}

	/**
	 * Transforms an associative array specified by its serialization property attributes.
	 * @param array $data The associative array to transform.
	 * @return stdClass The transformed associative array.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws NotASerializationContractException The class is not marked as a JSON contract.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	private function transformAssociativeArray( array $data ): stdClass
	{
		$transformedArray = new stdClass();
		foreach ( $data as $dataKey => $dataFetched )
		{
			$dataKey = (string) $dataKey;
			if ( true === is_array( $dataFetched ) )
			{
				if ( true === $this->isAssociativeArray( $dataFetched ) )
				{
					$transformedArray->{$dataKey} = $this->transformAssociativeArray( $dataFetched );
					continue;
				}
				$transformedArray->{$dataKey} = $this->transformSequencialArray( $dataFetched );
				continue;
			}
			if ( true === is_object( $dataFetched ) )
			{
				$transformedArray->{$dataKey} = $this->transformObject( $dataFetched );
				continue;
			}
			$transformedArray->{$dataKey} = $dataFetched;
		}

		return $transformedArray;
	}

	/**
	 * Transforms a sequencial array specified by its serialization property attributes.
	 * @param array $data The sequencial array to transform.
	 * @return array The transformed sequencial array.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws NotASerializationContractException The class is not marked as a JSON contract.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	private function transformSequencialArray( array $data ): array
	{
		$transformedArray = [];
		foreach ( $data as $dataFetched )
		{
			if ( true === is_array( $dataFetched ) )
			{
				if ( true === $this->isAssociativeArray( $dataFetched ) )
				{
					$transformedArray[] = $this->transformAssociativeArray( $dataFetched );
					continue;
				}
				$transformedArray[] = $this->transformSequencialArray( $dataFetched );
				continue;
			}
			if ( true === is_object( $dataFetched ) )
			{
				$transformedArray[] = $this->transformObject( $dataFetched );
				continue;
			}
			$transformedArray[] = $dataFetched;
		}

		return $transformedArray;
	}

	/**
	 * Transforms an object specified by its serialization property attributes.
	 * @param object $data The object to transform.
	 * @return mixed The transformed object.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws NotASerializationContractException The class is not marked as a JSON contract.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	private function transformObject( $data )
	{
		$parsedContract    = ( new SerializationContractParser( get_class( $data ) ) )
			->parse();
		$transformedObject =
			true === $parsedContract->getContractAttribute()->serializeSinglePropertyOnly
				? null
				: new stdClass();
		/**
		 * @var ParsedSerializationProperty $parsedPropertyFetched
		 */
		foreach ( $parsedContract->getParsedProperties() as $parsedPropertyFetched )
		{
			$serializationPropertyName = $parsedPropertyFetched->getPropertyAttribute()->name;
			$propertyValue             = $parsedPropertyFetched->getPropertyValue( $data );
			if ( true === is_array( $propertyValue ) )
			{
				if ( true === $this->isAssociativeArray( $propertyValue ) )
				{
					if ( null === $transformedObject )
					{
						$transformedObject = $this->transformAssociativeArray( $propertyValue );
						continue;
					}
					$transformedObject->{$serializationPropertyName} = $this->transformAssociativeArray( $propertyValue );
					continue;
				}
				if ( null === $transformedObject )
				{
					$transformedObject = $this->transformSequencialArray( $propertyValue );
					continue;
				}
				$transformedObject->{$serializationPropertyName} = $this->transformSequencialArray( $propertyValue );
				continue;
			}
			if ( true === is_object( $propertyValue ) )
			{
				if ( null === $transformedObject )
				{
					$transformedObject = $this->transformObject( $propertyValue );
					continue;
				}
				$transformedObject->{$serializationPropertyName} = $this->transformObject( $propertyValue );
				continue;
			}
			if ( null === $transformedObject )
			{
				$transformedObject = $propertyValue;
				continue;
			}
			$transformedObject->{$serializationPropertyName} = $propertyValue;
		}

		return $transformedObject;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize( $data ): string
	{
		try
		{
			return ( new JsonEncoder() )
				->encode(
					$this->transformObject( $data ),
					new JsonEncoderOptions(
						JsonEncoderOptions::PRESERVE_ZERO_FRACTION
					)
				);
		}
		catch ( SerializationContractNotFoundException
		| NotASerializationContractException
		| AnnotationReaderInstantiationFailedException
		| SerializationContractHasNoPropertiesException
		| SerializationContractHasTooMuchPropertiesException
		| JsonException $exception )
		{
			throw new SerializationFailedException(
				static::ERROR_SERIALIZATION_FAILED,
				0,
				$exception
			);
		}
	}

	/**
	 * Retransforms a sequencial array.
	 * @param array $data The array to retransform.
	 * @return array The retransformed array.
	 */
	private function retransformSequencialArray( array $data ): array
	{
		return $data;
	}

	/**
	 * Retransforms an object into an associative array.
	 * @param stdClass $data The object to retransform.
	 * @return array The retransformed associative array.
	 */
	private function retransformAssociativeArray( stdClass $data ): array
	{
		$retransformedArray = [];
		/**
		 * @var iterable $data
		 */
		foreach ( $data as $dataKey => $dataFetched )
		{
			$retransformedArray[ $dataKey ] = $dataFetched;
		}

		return $retransformedArray;
	}

	/**
	 * Retransforms an object specified by its serialization property attributes.
	 * @param mixed $data The object to retransform.
	 * @param string $class The name of the retransformed class.
	 * @return object The retransformed object.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws NotASerializationContractException The class is not marked as a JSON contract.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	private function retransformObject( $data, string $class )
	{
		$parsedContract              = ( new SerializationContractParser( $class ) )
			->parse();
		$serializeSinglePropertyOnly = $parsedContract->getContractAttribute()->serializeSinglePropertyOnly;
		$collectedType               = $parsedContract->getContractAttribute()->collectedType;
		$retransformedObject         = $parsedContract->getReflectedClass()->newInstanceWithoutConstructor();
		/**
		 * @var ParsedSerializationProperty $parsedPropertyFetched
		 */
		foreach ( $parsedContract->getParsedProperties() as $parsedPropertyFetched )
		{
			$serializationPropertyName = $parsedPropertyFetched->getPropertyAttribute()->name;
			if ( false === $serializeSinglePropertyOnly && false === isset( $data->{$serializationPropertyName} ) )
			{
				continue;
			}
			$serializationPropertyValue = true === $serializeSinglePropertyOnly ? $data : $data->{$serializationPropertyName};
			$serializationPropertyType  = $parsedPropertyFetched->getPropertyAttribute()->type;
			if ( null !== $serializationPropertyValue && '' === $serializationPropertyType && '' !== $collectedType )
			{
				$retransformedValue = [];
				/**
				 * @var array $serializationPropertyValue
				 */
				foreach ( $serializationPropertyValue as $serializationPropertyValueFetched )
				{
					$retransformedValue[] = $this->retransformObject( $serializationPropertyValueFetched, $collectedType );
				}
				$parsedPropertyFetched->setPropertyValue( $retransformedObject, $retransformedValue );
				continue;
			}
			if ( null !== $serializationPropertyValue && '' !== $serializationPropertyType )
			{
				$retransformedValue = $this->retransformObject( $serializationPropertyValue, $serializationPropertyType );
				$parsedPropertyFetched->setPropertyValue( $retransformedObject, $retransformedValue );
				continue;
			}
			if ( true === is_object( $serializationPropertyValue ) )
			{
				$retransformedValue = $this->retransformAssociativeArray( $serializationPropertyValue );
				$parsedPropertyFetched->setPropertyValue( $retransformedObject, $retransformedValue );
				continue;
			}
			if ( true === is_array( $serializationPropertyValue ) )
			{
				$retransformedValue = $this->retransformSequencialArray( $serializationPropertyValue );
				$parsedPropertyFetched->setPropertyValue( $retransformedObject, $retransformedValue );
				continue;
			}
			$parsedPropertyFetched->setPropertyValue( $retransformedObject, $serializationPropertyValue );
		}

		return $retransformedObject;
	}

	/**
	 * @inheritDoc
	 */
	public function deserialize( string $data, string $class ): object
	{
		try
		{
			return $this->retransformObject(
				( new JsonDecoder() )
					->decode( $data ),
				$class
			);
		}
		catch ( SerializationContractNotFoundException
		| NotASerializationContractException
		| AnnotationReaderInstantiationFailedException
		| SerializationContractHasNoPropertiesException
		| SerializationContractHasTooMuchPropertiesException
		| JsonException $exception )
		{
			throw new DeserializationFailedException(
				static::ERROR_DESERIALIZATION_FAILED,
				0,
				$exception
			);
		}
	}
}
