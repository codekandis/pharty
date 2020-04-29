<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents an enumeration of HTTP methods.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class HttpMethod
{
	/**
	 * Defines the HTTP method as `GET`.
	 * @var string
	 */
	public const GET = 'GET';

	/**
	 * Defines the HTTP method as `POST`.
	 * @var string
	 */
	public const POST = 'POST';

	/**
	 * Defines the HTTP method as `HEAD`.
	 * @var string
	 */
	public const HEAD = ' HEAD';

	/**
	 * Defines the HTTP method as `PUT`.
	 * @var string
	 */
	public const PUT = ' PUT';

	/**
	 * Defines the HTTP method as `PATCH`.
	 * @var string
	 */
	public const PATCH = ' PATCH';

	/**
	 * Defines the HTTP method as `DELETE`.
	 * @var string
	 */
	public const DELETE = ' DELETE';

	/**
	 * Defines the HTTP method as `TRACE`.
	 * @var string
	 */
	public const TRACE = ' TRACE';

	/**
	 * Defines the HTTP method as `OPTIONS`.
	 * @var string
	 */
	public const OPTIONS = ' OPTIONS';

	/**
	 * Defines the HTTP method as `CONNECT`.
	 * @var string
	 */
	public const CONNECT = ' CONNECT';
}
