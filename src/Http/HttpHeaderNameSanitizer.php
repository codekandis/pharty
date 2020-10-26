<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use function strtolower;
use function ucwords;

/**
 * Represents a HTTP header name sanitizer.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class HttpHeaderNameSanitizer implements HttpHeaderNameSanitizerInterface
{
	/**
	 * @inheritDoc
	 */
	public function sanitize( string $headerName ): string
	{
		return ucwords(
			strtolower(
				$headerName
			),
			'-'
		);
	}
}
