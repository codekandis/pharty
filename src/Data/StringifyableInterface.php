<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

/**
 * Represents the interface of all stringifyable classes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface StringifyableInterface
{
	/**
	 * Gets the string representation of the class.
	 * @return string The string representation of the class.
	 */
	public function __toString(): string;

	/**
	 * Gets the string representation of the class.
	 * @return string The string representation of the class.
	 */
	public function toString(): string;
}
