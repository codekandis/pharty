<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents an enumeration of HTTP response status codes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class HttpResponseStatusCode
{
	/**
	 * Defines the HTTP response status code of `100 Continue`.
	 * @var int
	 */
	public const CONTINUE = 100;

	/**
	 * Defines the HTTP response status code of `101 Switching Protocols`.
	 * @var int
	 */
	public const SWITCHING_PROTOCOLS = 101;

	/**
	 * Defines the HTTP response status code of `200 OK`.
	 * @var int
	 */
	public const OK = 200;

	/**
	 * Defines the HTTP response status code of `201 Created`.
	 * @var int
	 */
	public const CREATED = 201;

	/**
	 * Defines the HTTP response status code of `202 Accepted`.
	 * @var int
	 */
	public const ACCEPTED = 202;

	/**
	 * Defines the HTTP response status code of `203 Non-Authoritative Information`.
	 * @var int
	 */
	public const NON_AUTHORITATIVE_INFORMATION = 203;

	/**
	 * Defines the HTTP response status code of `204 No Content`.
	 * @var int
	 */
	public const NO_CONTENT = 204;

	/**
	 * Defines the HTTP response status code of `205 Reset Content`.
	 * @var int
	 */
	public const RESET_CONTENT = 205;

	/**
	 * Defines the HTTP response status code of `206 Partial Content`.
	 * @var int
	 */
	public const PARTIAL_CONTENT = 206;

	/**
	 * Defines the HTTP response status code of `300 Multiple Choices`.
	 * @var int
	 */
	public const MULTIPLE_CHOICES = 300;

	/**
	 * Defines the HTTP response status code of `301 Moved Permanently`.
	 * @var int
	 */
	public const MOVED_PERMANENTLY = 301;

	/**
	 * Defines the HTTP response status code of `302 Found`.
	 * @var int
	 */
	public const FOUND = 302;

	/**
	 * Defines the HTTP response status code of `303 See Other`.
	 * @var int
	 */
	public const SEE_OTHER = 303;

	/**
	 * Defines the HTTP response status code of `304 Not Modified`.
	 * @var int
	 */
	public const NOT_MODIFIED = 304;

	/**
	 * Defines the HTTP response status code of `305 Use Proxy`.
	 * @var int
	 */
	public const USE_PROXY = 305;

	/**
	 * Defines the HTTP response status code of `307 Temporary Redirect`.
	 * @var int
	 */
	public const TEMPORARY_REDIRECT = 307;

	/**
	 * Defines the HTTP response status code of `308 Permanent Redirect`.
	 * @var int
	 */
	public const PERMANENT_REDIRECT = 308;

	/**
	 * Defines the HTTP response status code of `400 Bad Request`.
	 * @var int
	 */
	public const BAD_REQUEST = 400;

	/**
	 * Defines the HTTP response status code of `401 Unauthorized`.
	 * @var int
	 */
	public const UNAUTHORIZED = 401;

	/**
	 * Defines the HTTP response status code of `402 Payment Required`.
	 * @var int
	 */
	public const PAYMENT_REQUIRED = 402;

	/**
	 * Defines the HTTP response status code of `403 Forbidden`.
	 * @var int
	 */
	public const FORBIDDEN = 403;

	/**
	 * Defines the HTTP response status code of `404 Not Found`.
	 * @var int
	 */
	public const NOT_FOUND = 404;

	/**
	 * Defines the HTTP response status code of `405 Method Not Allowed`.
	 * @var int
	 */
	public const METHOD_NOT_ALLOWED = 405;

	/**
	 * Defines the HTTP response status code of `406 Not Acceptable`.
	 * @var int
	 */
	public const NOT_ACCEPTABLE = 406;

	/**
	 * Defines the HTTP response status code of `407 Proxy Authentication Required`.
	 * @var int
	 */
	public const PROXY_AUTHENTICATION_REQUIRED = 407;

	/**
	 * Defines the HTTP response status code of `408 Request Timeout`.
	 * @var int
	 */
	public const REQUEST_TIMEOUT = 408;

	/**
	 * Defines the HTTP response status code of `409 Conflict`.
	 * @var int
	 */
	public const CONFLICT = 409;

	/**
	 * Defines the HTTP response status code of `410 Gone`.
	 * @var int
	 */
	public const GONE = 410;

	/**
	 * Defines the HTTP response status code of `411 Length Required`.
	 * @var int
	 */
	public const LENGTH_REQUIRED = 411;

	/**
	 * Defines the HTTP response status code of `412 Precondition Failed`.
	 * @var int
	 */
	public const PRECONDITION_FAILED = 412;

	/**
	 * Defines the HTTP response status code of `413 Request Entity Too Large`.
	 * @var int
	 */
	public const REQUEST_ENTITY_TOO_LARGE = 413;

	/**
	 * Defines the HTTP response status code of `414 Request-URI Too Long`.
	 * @var int
	 */
	public const REQUEST_URI_TOO_LONG = 414;

	/**
	 * Defines the HTTP response status code of `415 Unsupported Media Type`.
	 * @var int
	 */
	public const UNSUPPORTED_MEDIA_TYPE = 415;

	/**
	 * Defines the HTTP response status code of `416 Requested Range Not Satisfiable`.
	 * @var int
	 */
	public const REQUESTED_RANGE_NOT_SATISFIABLE = 416;

	/**
	 * Defines the HTTP response status code of `417 Expectation Failed`.
	 * @var int
	 */
	public const EXPECTATION_FAILED = 417;

	/**
	 * Defines the HTTP response status code of `426 Upgrade Required`.
	 * @var int
	 */
	public const UPGRADE_REQUIRED = 426;

	/**
	 * Defines the HTTP response status code of `428 Precondition Required`.
	 * @var int
	 */
	public const PRECONDITION_REQUIRED = 428;

	/**
	 * Defines the HTTP response status code of `429 Too Many Requests`.
	 * @var int
	 */
	public const TOO_MANY_REQUESTS = 429;

	/**
	 * Defines the HTTP response status code of `431 Request Header Fields Too Large`.
	 * @var int
	 */
	public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

	/**
	 * Defines the HTTP response status code of `451 Unavailable For Legal Reasons`.
	 * @var int
	 */
	public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

	/**
	 * Defines the HTTP response status code of `500 Internal Server Error`.
	 * @var int
	 */
	public const INTERNAL_SERVER_ERROR = 500;

	/**
	 * Defines the HTTP response status code of `501 Not Implemented`.
	 * @var int
	 */
	public const NOT_IMPLEMENTED = 501;

	/**
	 * Defines the HTTP response status code of `502 Bad Gateway`.
	 * @var int
	 */
	public const BAD_GATEWAY = 502;

	/**
	 * Defines the HTTP response status code of `503 Service Unavailable`.
	 * @var int
	 */
	public const SERVICE_UNAVAILABLE = 503;

	/**
	 * Defines the HTTP response status code of `504 Gateway Timeout`.
	 * @var int
	 */
	public const GATEWAY_TIMEOUT = 504;

	/**
	 * Defines the HTTP response status code of `505 HTTP Version Not Supported`.
	 * @var int
	 */
	public const HTTP_VERSION_NOT_SUPPORTED = 505;

	/**
	 * Defines the HTTP response status code of `506 Variant Also Negotiates`.
	 * @var int
	 */
	public const VARIANT_ALSO_NEGOTIATES = 506;

	/**
	 * Defines the HTTP response status code of `511 Network Authentication Required`.
	 * @var int
	 */
	public const NETWORK_AUTHENTICATION_REQUIRED = 511;
}
