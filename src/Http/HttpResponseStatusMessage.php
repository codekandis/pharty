<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents an enumeration of HTTP response status messages.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class HttpResponseStatusMessage
{
	/**
	 * Defines the HTTP response status message of `100 Continue`.
	 * @var int
	 */
	public const CONTINUE = 'Continue';

	/**
	 * Defines the HTTP response status message of `101 Switching Protocols`.
	 * @var int
	 */
	public const SWITCHING_PROTOCOLS = 'Switching Protocols';

	/**
	 * Defines the HTTP response status message of `200 OK`.
	 * @var int
	 */
	public const OK = 'OK';

	/**
	 * Defines the HTTP response status message of `201 Created`.
	 * @var int
	 */
	public const CREATED = 'Created';

	/**
	 * Defines the HTTP response status message of `202 Accepted`.
	 * @var int
	 */
	public const ACCEPTED = 'Accepted';

	/**
	 * Defines the HTTP response status message of `203 Non-Authoritative Information`.
	 * @var int
	 */
	public const NON_AUTHORITATIVE_INFORMATION = 'Non-Authoritative Information';

	/**
	 * Defines the HTTP response status message of `204 No Content`.
	 * @var int
	 */
	public const NO_CONTENT = 'No Content';

	/**
	 * Defines the HTTP response status message of `205 Reset Content`.
	 * @var int
	 */
	public const RESET_CONTENT = 'Reset Content';

	/**
	 * Defines the HTTP response status message of `206 Partial Content`.
	 * @var int
	 */
	public const PARTIAL_CONTENT = 'Partial Content';

	/**
	 * Defines the HTTP response status message of `300 Multiple Choices`.
	 * @var int
	 */
	public const MULTIPLE_CHOICES = 'Multiple Choices';

	/**
	 * Defines the HTTP response status message of `301 Moved Permanently`.
	 * @var int
	 */
	public const MOVED_PERMANENTLY = 'Moved Permanently';

	/**
	 * Defines the HTTP response status message of `302 Found`.
	 * @var int
	 */
	public const FOUND = 'Found';

	/**
	 * Defines the HTTP response status message of `303 See Other`.
	 * @var int
	 */
	public const SEE_OTHER = 'See Other';

	/**
	 * Defines the HTTP response status message of `304 Not Modified`.
	 * @var int
	 */
	public const NOT_MODIFIED = 'Not Modified';

	/**
	 * Defines the HTTP response status message of `305 Use Proxy`.
	 * @var int
	 */
	public const USE_PROXY = 'Use Proxy';

	/**
	 * Defines the HTTP response status message of `307 Temporary Redirect`.
	 * @var int
	 */
	public const TEMPORARY_REDIRECT = 'Temporary Redirect';

	/**
	 * Defines the HTTP response status message of `308 Permanent Redirect`.
	 * @var int
	 */
	public const PERMANENT_REDIRECT = 'Permanent Redirect';

	/**
	 * Defines the HTTP response status message of `400 Bad Request`.
	 * @var int
	 */
	public const BAD_REQUEST = 'Bad Request';

	/**
	 * Defines the HTTP response status message of `401 Unauthorized`.
	 * @var int
	 */
	public const UNAUTHORIZED = 'Unauthorized';

	/**
	 * Defines the HTTP response status message of `402 Payment Required`.
	 * @var int
	 */
	public const PAYMENT_REQUIRED = 'Payment Required';

	/**
	 * Defines the HTTP response status message of `403 Forbidden`.
	 * @var int
	 */
	public const FORBIDDEN = 'Forbidden';

	/**
	 * Defines the HTTP response status message of `404 Not Found`.
	 * @var int
	 */
	public const NOT_FOUND = 'Not Found';

	/**
	 * Defines the HTTP response status message of `405 Method Not Allowed`.
	 * @var int
	 */
	public const METHOD_NOT_ALLOWED = 'Method Not Allowed';

	/**
	 * Defines the HTTP response status message of `406 Not Acceptable`.
	 * @var int
	 */
	public const NOT_ACCEPTABLE = 'Not Acceptable';

	/**
	 * Defines the HTTP response status message of `407 Proxy Authentication Required`.
	 * @var int
	 */
	public const PROXY_AUTHENTICATION_REQUIRED = 'Proxy Authentication Required';

	/**
	 * Defines the HTTP response status message of `408 Request Timeout`.
	 * @var int
	 */
	public const REQUEST_TIMEOUT = 'Request Timeout';

	/**
	 * Defines the HTTP response status message of `409 Conflict`.
	 * @var int
	 */
	public const CONFLICT = 'Conflict';

	/**
	 * Defines the HTTP response status message of `410 Gone`.
	 * @var int
	 */
	public const GONE = 'Gone';

	/**
	 * Defines the HTTP response status message of `411 Length Required`.
	 * @var int
	 */
	public const LENGTH_REQUIRED = 'Length Required';

	/**
	 * Defines the HTTP response status message of `412 Precondition Failed`.
	 * @var int
	 */
	public const PRECONDITION_FAILED = 'Precondition Failed';

	/**
	 * Defines the HTTP response status message of `413 Request Entity Too Large`.
	 * @var int
	 */
	public const REQUEST_ENTITY_TOO_LARGE = 'Request Entity Too Large';

	/**
	 * Defines the HTTP response status message of `414 Request-URI Too Long`.
	 * @var int
	 */
	public const REQUEST_URI_TOO_LONG = 'Request-URI Too Long';

	/**
	 * Defines the HTTP response status message of `415 Unsupported Media Type`.
	 * @var int
	 */
	public const UNSUPPORTED_MEDIA_TYPE = 'Unsupported Media Type';

	/**
	 * Defines the HTTP response status message of `416 Requested Range Not Satisfiable`.
	 * @var int
	 */
	public const REQUESTED_RANGE_NOT_SATISFIABLE = 'Requested Range Not Satisfiable';

	/**
	 * Defines the HTTP response status message of `417 Expectation Failed`.
	 * @var int
	 */
	public const EXPECTATION_FAILED = 'Expectation Failed';

	/**
	 * Defines the HTTP response status message of `426 Upgrade Required`.
	 * @var int
	 */
	public const UPGRADE_REQUIRED = 'Upgrade Required';

	/**
	 * Defines the HTTP response status message of `428 Precondition Required`.
	 * @var int
	 */
	public const PRECONDITION_REQUIRED = 'Precondition Required';

	/**
	 * Defines the HTTP response status message of `429 Too Many Requests`.
	 * @var int
	 */
	public const TOO_MANY_REQUESTS = 'Too Many Requests';

	/**
	 * Defines the HTTP response status message of `431 Request Header Fields Too Large`.
	 * @var int
	 */
	public const REQUEST_HEADER_FIELDS_TOO_LARGE = 'Request Header Fields Too Large';

	/**
	 * Defines the HTTP response status message of `451 Unavailable For Legal Reasons`.
	 * @var int
	 */
	public const UNAVAILABLE_FOR_LEGAL_REASONS = 'Unavailable For Legal Reasons';

	/**
	 * Defines the HTTP response status message of `500 Internal Server Error`.
	 * @var int
	 */
	public const INTERNAL_SERVER_ERROR = 'Internal Server Error';

	/**
	 * Defines the HTTP response status message of `501 Not Implemented`.
	 * @var int
	 */
	public const NOT_IMPLEMENTED = 'Not Implemented';

	/**
	 * Defines the HTTP response status message of `502 Bad Gateway`.
	 * @var int
	 */
	public const BAD_GATEWAY = 'Bad Gateway';

	/**
	 * Defines the HTTP response status message of `503 Service Unavailable`.
	 * @var int
	 */
	public const SERVICE_UNAVAILABLE = 'Service Unavailable';

	/**
	 * Defines the HTTP response status message of `504 Gateway Timeout`.
	 * @var int
	 */
	public const GATEWAY_TIMEOUT = 'Gateway Timeout';

	/**
	 * Defines the HTTP response status message of `505 HTTP Version Not Supported`.
	 * @var int
	 */
	public const HTTP_VERSION_NOT_SUPPORTED = 'HTTP Version Not Supported';

	/**
	 * Defines the HTTP response status message of `506 Variant Also Negotiates`.
	 * @var int
	 */
	public const VARIANT_ALSO_NEGOTIATES = 'Variant Also Negotiates';

	/**
	 * Defines the HTTP response status message of `511 Network Authentication Required`.
	 * @var int
	 */
	public const NETWORK_AUTHENTICATION_REQUIRED = 'Network Authentication Required';
}
