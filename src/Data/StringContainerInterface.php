<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

/**
 * Represents the interface of all string containers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface StringContainerInterface extends StringifyableInterface
{
	/**
	 * Gets the content of the string container.
	 * @return string The content of the string container.
	 */
	public function getContent(): string;

	/**
	 * Gets the length of the content of the string container.
	 * @return int The length of the content of the string container.
	 */
	public function getLength(): int;

	/**
	 * Adds content to the string container.
	 * @param string $content The content to add to the string container.
	 */
	public function addContent( string $content ): void;

	/**
	 * Adds the content of a string container to the string container.
	 * @param StringContainerInterface $container The string container to add its content to the string container.
	 */
	public function addContainer( StringContainerInterface $container ): void;
}
