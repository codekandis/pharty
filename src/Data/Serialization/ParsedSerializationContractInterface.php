<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Collections\ImmutableListInterface;
use ReflectionClass;

/**
 * Represents the interface of all parsed serialization contracts.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ParsedSerializationContractInterface
{
	/**
	 * Gets the serialization contract.
	 * @return ReflectionClass The serialization contract.
	 */
	public function getReflectedClass(): ReflectionClass;

	/**
	 * Gets the name of the parsed serialization contract.
	 * @return string The name of the parsed serialization contract.
	 */
	public function getContractName(): string;

	/**
	 * Gets the serialization contract attribute of the parsed serialization contract.
	 * @return SerializationContractAttribute The serialization contract attribute of the parsed serialization contract.
	 */
	public function getContractAttribute(): SerializationContractAttribute;

	/**
	 * Gets the list of parsed serialization properties of the parsed contract.
	 * @return ImmutableListInterface The list of parsed serialization properties of the parsed contract.
	 */
	public function getParsedProperties(): ImmutableListInterface;

	/**
	 * Sets the list of parsed serialization properties of the parsed contract.
	 * @param ImmutableListInterface $parsedProperties The list of parsed serialization properties of the parsed contract.
	 */
	public function setParsedProperties( ImmutableListInterface $parsedProperties ): void;
}
