<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessor;
use function is_string;
use function preg_match;

/**
 * Represents a router.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Router implements RouterInterface
{
	/**
	 * Stores the routes of the router.
	 * @var RouteInterface[]
	 */
	private array $routes;

	/**
	 * Constructor method.
	 * @param RouteInterface[] $routes The routes of the router.
	 */
	public function __construct( array $routes )
	{
		$this->routes = $routes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function resolveRoute( string $httpMethod, string $uri ): ?ResolvedRouteInterface
	{
		foreach ( $this->routes as $routeFetched )
		{
			$routeHttpMethod = $routeFetched->getHttpMethod();
			$routePattern    = $routeFetched->getPattern();
			$matches         = [];
			if (
				$httpMethod === $routeHttpMethod
				&& 1 === preg_match( '~' . $routePattern . '~', $uri, $matches )
			)
			{
				$routeFetchedData = $routeFetched->getData();
				$dataAccessor     = new ArrayAccessor( $routeFetchedData );
				foreach ( $matches as $matchIndex => $matchFetched )
				{
					if ( true === is_string( $matchIndex ) )
					{
						$dataAccessor->set( $matchIndex, $matchFetched );
					}
				}

				return new ResolvedRoute( $routeFetched, $dataAccessor );
			}
		}

		return null;
	}
}
