<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Http\HttpDataInterface;

/**
 * Represents the interface of all application environment classes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface EnvironmentInterface
{
	/**
	 * Gets the name of the application.
	 * @return string The name of the application.
	 */
	public function getApplicationName(): string;

	/**
	 * Gets the HTTP data of the request.
	 * @return HttpDataInterface The HTTP data of the request.
	 */
	public function getHttpData(): HttpDataInterface;
}
