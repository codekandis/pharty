<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Data\StringContainerInterface;
use CodeKandis\Pharty\Http\HttpResponseHeaders;
use CodeKandis\Pharty\Http\HttpResponseHeadersInterface;
use CodeKandis\Pharty\Http\HttpResponseStatusCode;

/**
 * Represents the base class of all layout preprocessors.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class LayoutPreProcessor implements LayoutPreProcessorInterface
{
	/**
	 * Stores the response headers of the response.
	 * @var HttpResponseHeadersInterface
	 */
	protected HttpResponseHeadersInterface $responseHeaders;

	/**
	 * Stores the HTTP response status code of the response.
	 * @var int
	 */
	private int $responseStatusCode;

	/**
	 * Stores the content type of the response.
	 * @var ?string
	 */
	private ?string $contentType;

	/**
	 * Constructor method.
	 * @param ?string The content type of the response, null otherwise.
	 * @param int $responseStatusCode The HTTP response status code of the response.
	 */
	public function __construct( ?string $contentType = null, int $responseStatusCode = HttpResponseStatusCode::OK )
	{
		$this->responseHeaders    = new HttpResponseHeaders();
		$this->responseStatusCode = $responseStatusCode;
		$this->contentType        = $contentType;
	}

	/**
	 * @inheritDoc
	 */
	public function getResponseHeaders(): HttpResponseHeadersInterface
	{
		return $this->responseHeaders;
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
	public function getContentType(): ?string
	{
		return $this->contentType;
	}

	/**
	 * @inheritDoc
	 */
	public function execute( StringContainerInterface $content ): void
	{
		$this->responseHeaders->setStatusCode( $this->getResponseStatusCode() );
		if ( null !== $this->contentType )
		{
			$this->responseHeaders->setHeaderValue( 'content-type', $this->contentType );
		}
		$this->responseHeaders->setHeaderValue( 'content-length', (string) $content->getLength() );
	}
}
