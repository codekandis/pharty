<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

/**
 * Represents the interface of all routes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface RouteInterface
{
	/**
	 * Gets the pattern of the route.
	 * @return string The pattern of the route.
	 */
	public function getPattern(): string;

	/**
	 * Gets the HTTP method of the route.
	 * @return string The HTTP method of the route.
	 */
	public function getHttpMethod(): string;

	/**
	 * Gets the class path of the controller of the route.
	 * @return string The class path of the controller of the route.
	 */
	public function getClass(): string;

	/**
	 * Gets the data of the controller of the rouute.
	 * @return array The data of the controller of the rouute.
	 */
	public function getData(): array;
}
