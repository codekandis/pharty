<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessorInterface;

/**
 * Represents the interface of all resolved routes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ResolvedRouteInterface
{
	/**
	 * Gets the route of the resolved route.
	 * @return RouteInterface The route of the resolved route.
	 */
	public function getRoute(): RouteInterface;

	/**
	 * Gets the data of the resolved route.
	 * @return ArrayAccessorInterface The data of the resolved route.
	 */
	public function getData(): ArrayAccessorInterface;
}
