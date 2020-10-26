<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

/**
 * Represents the interface of all HTTP header name sanitizers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface HttpHeaderNameSanitizerInterface
{
	/**
	 * Sanitizes the header name.
	 * @param string $headerName The header name to sanitize.
	 * @return string The sanitized header name.
	 */
	public function sanitize( string $headerName ): string;
}
