<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Annotations\AnnotationController;
use CodeKandis\Pharty\Annotations\AnnotationReaderInstantiationFailedException;
use CodeKandis\Pharty\Collections\Set;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionException;
use function count;
use function sprintf;

/**
 * Represents a serialization contract parser.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SerializationContractParser implements SerializationContractParserInterface
{
	/**
	 * Represents the error message if a serialization contract does not exist.
	 * @var string
	 */
	protected const ERROR_SERIALIZATION_CONTRACT_DOES_NOT_EXIST = 'The serialization contract \'%s\' does not exist.';

	/**
	 * Represents the error message if a class ist not marked as a serialization contract.
	 * @var string
	 */
	protected const ERROR_CLASS_IS_NOT_A_SERIALIZATION_CONTRACT = 'The class \'%s\' is not marked as a serialization contract.';

	/**
	 * Represents the error message if a class has not properties marked for serialization.
	 * @var string
	 */
	protected const ERROR_CLASS_HAS_NO_SERIALIZABLE_PROPERTIES = 'The serialization contract \'%s\' has no properties marked for serialization.';

	/**
	 * Represents the error message if a serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 * @var string
	 */
	protected const ERROR_SINGLE_PROPERTY_SERIALIZATION_CONTRACT_HAS_TOO_MUCH_SERIALIZABLE_PROPERTIES = 'The serialization contract \'%s\' is marked as serialize single property only but has more than one properties marked for serialization.';

	/**
	 * Stores the class to parse.
	 * @var string
	 */
	private string $class;

	/**
	 * Stores the reflected class of the class to parse.
	 * @var null|ReflectionClass
	 */
	private ?ReflectionClass $reflectedClass;

	/**
	 * Stores the Doctrine annotation reader of the validator.
	 * @var AnnotationReader
	 */
	private AnnotationReader $annotationReader;

	/**
	 * Constructor method.
	 * @param string $class The class to parse.
	 */
	public function __construct( string $class )
	{
		$this->class = $class;
	}

	/**
	 * Gets the reflected class of the class to parse.
	 * @return null|ReflectionClass The reflected class of the class to parse.
	 */
	private function getReflectedClass(): ?ReflectionClass
	{
		try
		{
			return $this->reflectedCass ?? $this->reflectedClass = new ReflectionClass( $this->class );
		}
		catch ( ReflectionException $exception )
		{
			return null;
		}
	}

	/**
	 * Gets the Doctrine annotation reader of the validator.
	 * @return AnnotationReader The Doctrine annotation reader of the validator.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 */
	private function getAnnotationReader(): AnnotationReader
	{
		return $this->annotationReader ?? $this->annotationReader = ( new AnnotationController() )->getAnnotationReader();
	}

	/**
	 * Validates if the class representing a serialization contract exists and is marked as a serialization contract.
	 * @return ParsedSerializationContractInterface The parsed serialization contract.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws NotASerializationContractException The class is not marked as a serialization contract.
	 */
	private function parseIsContract(): ParsedSerializationContractInterface
	{
		$reflectedClass = $this->getReflectedClass();
		if ( null === $reflectedClass )
		{
			throw new SerializationContractNotFoundException(
				sprintf(
					static::ERROR_SERIALIZATION_CONTRACT_DOES_NOT_EXIST,
					$this->class
				)
			);
		}
		/* @var SerializationContractAttribute $classAttribute */
		$classAttribute = $this->getAnnotationReader()->getClassAnnotation( $reflectedClass, SerializationContractAttribute::class );
		if ( null === $classAttribute )
		{
			throw new NotASerializationContractException(
				sprintf(
					static::ERROR_CLASS_IS_NOT_A_SERIALIZATION_CONTRACT,
					$this->class
				)
			);
		}

		return new ParsedSerializationContract( $reflectedClass, $classAttribute );
	}

	/**
	 * Validates if the serialization contract has any properties marked as serialization property.
	 * @param ParsedSerializationContractInterface $parsedContract The parsed serialization contract.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	private function parseProperties( ParsedSerializationContractInterface $parsedContract ): void
	{
		$parsedProperties = new Set();
		foreach ( $parsedContract->getReflectedClass()->getProperties() as $reflectedPropertyFetched )
		{
			$propertyAttribute = $this->getAnnotationReader()->getPropertyAnnotation( $reflectedPropertyFetched, SerializationPropertyAttribute::class );
			if ( null !== $propertyAttribute )
			{
				/* @var SerializationPropertyAttribute $propertyAttribute */
				if ( '' === $propertyAttribute->name )
				{
					$propertyAttribute->name = $reflectedPropertyFetched->name;
				}
				$parsedProperties->add(
					new ParsedSerializationProperty( $reflectedPropertyFetched, $propertyAttribute )
				);
			}
		}
		$propertyAttributesCount = count( $parsedProperties );
		if ( 0 === $propertyAttributesCount )
		{
			throw new SerializationContractHasNoPropertiesException(
				sprintf(
					static::ERROR_CLASS_HAS_NO_SERIALIZABLE_PROPERTIES,
					$this->class
				)
			);
		}
		if (
			true === $parsedContract->getContractAttribute()->serializeSinglePropertyOnly
			&& 1 < $propertyAttributesCount
		)
		{
			throw new SerializationContractHasTooMuchPropertiesException(
				sprintf(
					static::ERROR_SINGLE_PROPERTY_SERIALIZATION_CONTRACT_HAS_TOO_MUCH_SERIALIZABLE_PROPERTIES,
					$this->class
				)
			);
		}
		$parsedContract->setParsedProperties( $parsedProperties );
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse(): ParsedSerializationContractInterface
	{
		$parsedContract = $this->parseIsContract();
		$this->parseProperties( $parsedContract );

		return $parsedContract;
	}
}
