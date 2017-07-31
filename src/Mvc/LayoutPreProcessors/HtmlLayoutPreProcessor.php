<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Http\HttpResponseStatusCode;

/**
 * Represents a HTML layout preprocessor.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class HtmlLayoutPreProcessor extends LayoutPreProcessor
{
	/**
	 * Constructor method.
	 * @param int $responseStatusCode The HTTP response status code of the response.
	 */
	public function __construct( int $responseStatusCode = HttpResponseStatusCode::OK )
	{
		parent::__construct( 'text/html; charset=utf-8', $responseStatusCode );
	}
}
