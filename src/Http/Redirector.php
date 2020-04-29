<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use function header;

/**
 * Represents a HTTP redirector.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Redirector implements RedirectorInterface
{
	/**
	 * Stores the URI to redirect to.
	 * @var string
	 */
	private string $uri;

	/**
	 * Stores the HTTP response status code.
	 * @var int
	 */
	private int $statusCode;

	/**
	 * Constructor method.
	 * @param string $uri The URI to redirect to.
	 * @param int $statusCode The HTTP response status code.
	 */
	public function __construct( string $uri, int $statusCode )
	{
		$this->uri        = $uri;
		$this->statusCode = $statusCode;
	}

	/**
	 * Executes the HTTP redirector.
	 */
	public function execute(): void
	{
		header( 'Location: ' . $this->uri, true, $this->statusCode );
	}
}
