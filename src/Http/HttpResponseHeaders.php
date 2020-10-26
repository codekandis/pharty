<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use function array_key_exists;
use function header;
use function http_response_code;

/**
 * Represents response headers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class HttpResponseHeaders implements HttpResponseHeadersInterface
{
	/**
	 * Stores the header name sanitizer.
	 * @var HttpHeaderNameSanitizer
	 */
	private HttpHeaderNameSanitizer $headerNameSanitizer;

	/**
	 * Stores the status code of the response.
	 * @var int
	 */
	private int $statusCode = HttpResponseStatusCode::OK;

	/**
	 * Stores the headers of the response.
	 * @var HttpHeaderInterface[]
	 */
	private array $headers = [];

	/**
	 * Constructor method.
	 */
	public function __construct()
	{
		$this->headerNameSanitizer = new HttpHeaderNameSanitizer();
	}

	/**
	 * @inheritDoc
	 */
	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	/**
	 * @inheritDoc
	 */
	public function setStatusCode( int $statusCode ): void
	{
		$this->statusCode = $statusCode;
	}

	/**
	 * @inheritDoc
	 */
	public function getHeaderValue( string $name ): ?string
	{
		return false === array_key_exists( $this->sanitizeHeaderName( $name ), $this->headers )
			? null
			: $this->headers[ $this->sanitizeHeaderName( $name ) ]->getValue();
	}

	/**
	 * @inheritDoc
	 */
	public function setHeaderValue( string $name, string $value ): void
	{
		$this->headers[ $this->sanitizeHeaderName( $name ) ] = new HttpHeader( $name, $value );
	}

	/**
	 * @inheritDoc
	 */
	public function getHeader( string $name ): ?HttpHeaderInterface
	{
		return $this->headers[ $this->sanitizeHeaderName( $name ) ] ?? null;
	}

	/**
	 * @inheritDoc
	 */
	public function setHeader( HttpHeaderInterface $header ): void
	{
		$this->headers[ $header->getName() ] = $header;
	}

	/**
	 * @inheritDoc
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @inheritDoc
	 */
	public function flush(): void
	{
		http_response_code( $this->statusCode );
		foreach ( $this->headers as $header )
		{
			header( $header->toString() );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function merge( HttpResponseHeadersInterface $responseHeaders ): HttpResponseHeadersInterface
	{
		$mergedResponseHeaders = new HttpResponseHeaders();

		$mergedResponseHeaders->setStatusCode( $responseHeaders->statusCode );
		foreach ( $this->headers as $header )
		{
			$mergedResponseHeaders->setHeader( $header );
		}
		foreach ( $responseHeaders->getHeaders() as $header )
		{
			$mergedResponseHeaders->setHeader( $header );
		}

		return $mergedResponseHeaders;
	}

	/**
	 * Sanitizes a header name.
	 * @param string $headerName The header name to sanitize.
	 * @return string The sanitized header name.
	 */
	private function sanitizeHeaderName( string $headerName ): string
	{
		return $this->headerNameSanitizer->sanitize( $headerName );
	}
}
