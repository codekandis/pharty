<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

/**
 * Represents the interface of all parsed serialization properties of a serialization contract.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ParsedSerializationPropertyInterface
{
	/**
	 * Gets the name of the parsed serialization property of the serialization contract.
	 * @return string The name of the parsed serialization property of the serialization contract.
	 */
	public function getPropertyName(): string;

	/**
	 * Gets the value of the parsed serialization property of the serialization contract.
	 * @param object $serializationContract The serialization contract to get its property value from.
	 * @return mixed The value of the parsed serialization property of the serialization contract.
	 */
	public function getPropertyValue( object $serializationContract );

	/**
	 * Sets the value of the parsed serialization property of the serialization contract.
	 * @param object $serializationContract The serialization contract to set its property value.
	 * @param mixed $value The value of the property to set.
	 */
	public function setPropertyValue( object $serializationContract, $value ): void;

	/**
	 * Gets the serialization property attribute of the parsed serialization property of the serialization contract.
	 * @return SerializationPropertyAttribute The serialization property attribute of the parsed serialization property of the serialization contract.
	 */
	public function getPropertyAttribute(): SerializationPropertyAttribute;
}
