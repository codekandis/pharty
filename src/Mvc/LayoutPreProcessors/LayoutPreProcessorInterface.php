<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Data\StringContainerInterface;
use CodeKandis\Pharty\Http\HttpResponseHeadersInterface;

/**
 * Represents the interface of all layout preprocessors.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LayoutPreProcessorInterface
{
	/**
	 * Gets the response headers of the response.
	 * @return HttpResponseHeadersInterface The response headers of the response.
	 */
	public function getResponseHeaders(): HttpResponseHeadersInterface;

	/**
	 * Gets the response status code of the layout.
	 * @return int The response status code of the layout.
	 */
	public function getResponseStatusCode(): int;

	/**
	 * Gets the content type of the layout.
	 * @return string The content type of the layout.
	 */
	public function getContentType(): string;

	/**
	 * Executes the layout preprocessor.
	 * @param StringContainerInterface $content The response content of the layout.
	 */
	public function execute( StringContainerInterface $content ): void;
}
