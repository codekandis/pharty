<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

/**
 * Represents the interface of all array accessors managing arrays by reference.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ArrayAccessorInterface
{
	/**
	 * Determines if the array has a specific key value pair.
	 * @param string $key The key to determine if it exists.
	 * @return bool True if the array has the specific key value pair, false otherwise.
	 */
	public function has( string $key ): bool;

	/**
	 * Gets a value from the array.
	 * @param string $key The key to get its value from the array.
	 * @return mixed The value from the array.
	 * @throws ArrayKeyNotFoundException The passed key does not exist.
	 */
	public function get( string $key );

	/**
	 * Gets a value from the array or a specific default value, if the key value pair does not exist.
	 * @param string $key The key to get its value from the array.
	 * @param mixed $default The default value if the key value pair does not exist.
	 * @return mixed The value from the array.
	 */
	public function getDefaulted( string $key, $default );

	/**
	 * Sets a value of the array.
	 * @param string $key The key to set its value to the array.
	 * @param mixed $value The value to set to the array.
	 */
	public function set( string $key, $value ): void;

	/**
	 * Unsets a value from the array.
	 * @param string $key The key to unset its value from the array.
	 * @throws ArrayKeyNotFoundException The passed key does not exist.
	 */
	public function unset( string $key ): void;
}
