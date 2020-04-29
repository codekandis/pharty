<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

/**
 * Represents the interface of all value converters.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ConverterInterface
{
	/**
	 * Converts a value into another value.
	 * @param mixed $value The value to convert.
	 * @return mixed The converted value.
	 */
	public function convert( $value );
}
