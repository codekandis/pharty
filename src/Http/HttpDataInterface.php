<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use CodeKandis\Pharty\Data\ArrayAccessorInterface;

/**
 * Represents the interface of all HTTP data containers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface HttpDataInterface
{
	/**
	 * Gets the HTTP SERVER data.
	 * @return ArrayAccessorInterface The HTTP SERVER data.
	 */
	public function getServer(): ArrayAccessorInterface;

	/**
	 * Gets the HTTP GET data.
	 * @return ArrayAccessorInterface The HTTP GET data.
	 */
	public function getGet(): ArrayAccessorInterface;

	/**
	 * Gets the HTTP POST data.
	 * @return ArrayAccessorInterface The HTTP GET data.
	 */
	public function getPost(): ArrayAccessorInterface;
}
