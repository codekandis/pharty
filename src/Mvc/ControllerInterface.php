<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

/**
 * Represents the interface of all controllers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ControllerInterface
{
	/**
	 * Executes the controller.
	 * @return bool True if the next controller can be executed, false otherwise.
	 */
	public function execute(): bool;
}
