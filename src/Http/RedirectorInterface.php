<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents the interface of all HTTP redirectors.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface RedirectorInterface
{
	/**
	 * Executes the HTTP redirector.
	 */
	public function execute(): void;
}
