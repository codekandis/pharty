<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

/**
 * Represents the interface of all routers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface RouterInterface
{
	/**
	 * Resolves the route of a specified URI.
	 * @param string httpMethod The HTTP method of the request.
	 * @param string $uri The URI to resolve its route.
	 * @return ?ResolvedRouteInterface The resolved route of the URI.
	 */
	public function resolveRoute( string $httpMethod, string $uri ): ?ResolvedRouteInterface;
}
