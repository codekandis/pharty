<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc\LayoutPreProcessors;

use CodeKandis\Pharty\Data\StringContainerInterface;

/**
 * Represents the interface of all layout preprocessors.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LayoutPreProcessorInterface
{
	/**
	 * Gets the content type of the layout.
	 * @return string The content type of the layout.
	 */
	public function getContentType(): string;

	/**
	 * Gets the response status code of the layout.
	 * @return int The response status code of the layout.
	 */
	public function getResponseStatusCode(): int;

	/**
	 * Executes the layout preprocessor.
	 * @param StringContainerInterface $content The response content of the layout.
	 */
	public function execute( StringContainerInterface $content ): void;
}
