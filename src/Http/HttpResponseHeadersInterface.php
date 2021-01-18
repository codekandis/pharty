<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use Symfony\Component\Mime\Header\HeaderInterface;

/**
 * Represents the interface of all HTTP response headers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface HttpResponseHeadersInterface
{
	/**
	 * Gets the status code of the response.
	 * @return int The status code of the response.
	 */
	public function getStatusCode(): int;

	/**
	 * Sets the status code of the response.
	 * @param int $statusCode The status code of the response.
	 */
	public function setStatusCode( int $statusCode ): void;

	/**
	 * Gets the value of a specific header.
	 * @param string $name The name of the header.
	 * @return ?string The value of the header if set, null otherwise.
	 */
	public function getHeaderValue( string $name ): ?string;

	/**
	 * Sets a specific header value.
	 * @param string $name The name of the header.
	 * @param string $value The value of the header.
	 */
	public function setHeaderValue( string $name, string $value ): void;

	/**
	 * Gets a specific header.
	 * @param string $name The name of the header.
	 * @return ?HttpHeaderInterface The header if set, null otherwise
	 */
	public function getHeader( string $name ): ?HttpHeaderInterface;

	/**
	 * Sets a specific header.
	 * @param HttpHeaderInterface $header The header.
	 */
	public function setHeader( HttpHeaderInterface $header ): void;

	/**
	 * Gets the set headers.
	 * @return HeaderInterface[]
	 */
	public function getHeaders(): array;

	/**
	 * Sends the response status code and the headers.
	 */
	public function flush(): void;

	/**
	 * Merges response headers.
	 * @param HttpResponseHeadersInterface $responseHeaders The response headers to merge.
	 * @return HttpResponseHeadersInterface The merged response headers.
	 */
	public function merge( HttpResponseHeadersInterface $responseHeaders ): HttpResponseHeadersInterface;
}
