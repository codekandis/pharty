<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

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
}
