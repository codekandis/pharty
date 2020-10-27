<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Data\StringContainerInterface;
use CodeKandis\Pharty\Http\HttpResponseStatusCode;

/**
 * Represents an mimeless stream layout preprocessor.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ContentTypeLessStreamLayoutPreProcessor extends LayoutPreProcessor
{
	/**
	 * Constructor method.
	 * @param int $responseStatusCode The HTTP response status code of the response.
	 */
	public function __construct( int $responseStatusCode = HttpResponseStatusCode::OK )
	{
		parent::__construct( null, $responseStatusCode );
	}

	/**
	 * @inheritDoc
	 */
	public function execute( StringContainerInterface $content ): void
	{
		parent::execute( $content );
		$this->responseHeaders->setHeaderValue( 'content-transfer-encoding', 'binary' );
		$this->responseHeaders->setHeaderValue( 'expires', '0' );
		$this->responseHeaders->setHeaderValue( 'cache-control', 'must-revalidate' );
		$this->responseHeaders->setHeaderValue( 'pragma', 'public' );
	}
}
