<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use ReflectionProperty;

/**
 * Represents a parsed serialization property of a serialization contract.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ParsedSerializationProperty implements ParsedSerializationPropertyInterface
{
	/**
	 * Stores the reflected serialization property of the serialization contract.
	 * @var ReflectionProperty
	 */
	private ReflectionProperty $reflectedProperty;

	/**
	 * Stores the serialization property attribute of the parsed serialization property of the serialization contract.
	 * @var SerializationPropertyAttribute
	 */
	private SerializationPropertyAttribute $propertyAttribute;

	/**
	 * Constructor method.
	 * @param ReflectionProperty $reflectedProperty The reflected serialization property of the serialization contract.
	 * @param SerializationPropertyAttribute $propertyAttribute The serialization property attribute of the parsed serialization property of the serialization contract.
	 */
	public function __construct( ReflectionProperty $reflectedProperty, SerializationPropertyAttribute $propertyAttribute )
	{
		$reflectedProperty->setAccessible( true );
		$this->reflectedProperty = $reflectedProperty;
		$this->propertyAttribute = $propertyAttribute;
	}

	/**
	 * @inheritDoc
	 */
	public function getPropertyName(): string
	{
		return $this->reflectedProperty->getName();
	}

	/**
	 * @inheritDoc
	 */
	public function getPropertyValue( object $serializationContract )
	{
		return $this->reflectedProperty->getValue( $serializationContract );
	}

	/**
	 * @inheritDoc
	 */
	public function setPropertyValue( object $serializationContract, $value ): void
	{
		$this->reflectedProperty->setValue( $serializationContract, $value );
	}

	/**
	 * @inheritDoc
	 */
	public function getPropertyAttribute(): SerializationPropertyAttribute
	{
		return $this->propertyAttribute;
	}
}
