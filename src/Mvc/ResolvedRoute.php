<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessorInterface;

/**
 * Represents a resolved route.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ResolvedRoute implements ResolvedRouteInterface
{
	/**
	 * Stores the route of the resolved route.
	 * @var RouteInterface
	 */
	private RouteInterface $route;

	/**
	 * Stores the data of the resolved route.
	 * @var ArrayAccessorInterface
	 */
	private ArrayAccessorInterface $data;

	/**
	 * Constrctor method.
	 * @param RouteInterface $route The route of the resolved route.
	 * @param ArrayAccessorInterface $data The data of the resolved route.
	 */
	public function __construct( RouteInterface $route, ArrayAccessorInterface $data )
	{
		$this->route = $route;
		$this->data  = $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRoute(): RouteInterface
	{
		return $this->route;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getData(): ArrayAccessorInterface
	{
		return $this->data;
	}
}
