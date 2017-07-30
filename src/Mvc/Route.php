<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

/**
 * Represents a route.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Route implements RouteInterface
{
	/**
	 * Stores the pattern of the route.
	 * @var string
	 */
	private string $pattern;

	/**
	 * Stores the HTTP method of the route.
	 * @var string
	 */
	private string $httpMethod;

	/**
	 * Stores the class path of the controller of the route.
	 * @var string
	 */
	private string $class;

	/**
	 * Stores the data of the controller of the route.
	 * @var array
	 */
	private array $data;

	/**
	 * Constructor method.
	 * @param string $pattern The pattern of the route.
	 * @param string $httpMethod The HTTP method of the route.
	 * @param string $class The class path of the controller of the route.
	 * @param array $data The data of the controller of the route.
	 */
	public function __construct( string $pattern, string $httpMethod, string $class, array $data )
	{
		$this->pattern    = $pattern;
		$this->httpMethod = $httpMethod;
		$this->class      = $class;
		$this->data       = $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPattern(): string
	{
		return $this->pattern;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHttpMethod(): string
	{
		return $this->httpMethod;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getClass(): string
	{
		return $this->class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getData(): array
	{
		return $this->data;
	}
}
