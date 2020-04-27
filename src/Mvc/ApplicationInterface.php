<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

/**
 * Represents the interface of all application classes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ApplicationInterface
{
	/**
	 * Gets the name of the application.
	 * @return string The name of the application.
	 */
	public function getName(): string;

	/**
	 * Executes the application.
	 */
	public function execute(): void;
}
