<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents the interface of all HTTP headers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface HttpHeaderInterface
{
	/**
	 * Gets the name of the header.
	 * @return string The name of the header.
	 */
	public function getName(): string;

	/**
	 * Gets the value of the header.
	 * @return string The value of the header.
	 */
	public function getValue(): string;

	/**
	 * Gets the string representation of the header.
	 * @return string The string representation of the header.
	 */
	public function __toString(): string;

	/**
	 * Gets the string representation of the header.
	 * @return string The string representation of the header.
	 */
	public function toString(): string;
}
