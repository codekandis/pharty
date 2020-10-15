<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Data\StringContainerInterface;
use CodeKandis\Pharty\Http\HttpResponseStatusCode;
use function header;
use function http_response_code;

/**
 * Represents the base class of all layout preprocessors.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class LayoutPreProcessor implements LayoutPreProcessorInterface
{
	/**
	 * Stores the content type of the response.
	 * @var string
	 */
	private string $contentType;

	/**
	 * Stores the HTTP response status code of the response.
	 * @var int
	 */
	private int $responseStatusCode;

	/**
	 * Constructor method.
	 * @param string The content type of the response.
	 * @param int $responseStatusCode The HTTP response status code of the response.
	 */
	public function __construct( string $contentType, int $responseStatusCode = HttpResponseStatusCode::OK )
	{
		$this->contentType        = $contentType;
		$this->responseStatusCode = $responseStatusCode;
	}

	/**
	 * @inheritDoc
	 */
	public function getContentType(): string
	{
		return $this->contentType;
	}

	/**
	 * @inheritDoc
	 */
	public function getResponseStatusCode(): int
	{
		return $this->responseStatusCode;
	}

	/**
	 * @inheritDoc
	 */
	public function execute( StringContainerInterface $content ): void
	{
		http_response_code( $this->responseStatusCode );
		header( 'Content-Type: ' . $this->contentType );
		header( 'Content-Length: ' . $content->getLength() );
	}
}
