<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use CodeKandis\Pharty\Data\StringifyableInterface;

/**
 * Represents the interface of all paths.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface PathInterface extends StringifyableInterface
{
	/**
	 * Gets the directory name of the path.
	 * @return string The directory name of the path.
	 */
	public function getDirectoryName(): string;

	/**
	 * Gets the base name of the path.
	 * @return string The base name of the path.
	 */
	public function getBaseName(): string;

	/**
	 * Gets the name of the path.
	 * @return string The name of the path.
	 */
	public function getName(): string;

	/**
	 * Gets the extension of the path.
	 * @return string The extension of the path.
	 */
	public function getExtension(): string;

	/**
	 * {@inheritdoc}
	 * Gets the full stringified path of the path.
	 * @return string The full stringified path of the path.
	 */
	public function __toString(): string;

	/**
	 * {@inheritdoc}
	 * Gets the full stringified path of the path.
	 * @return string The full stringified path of the path.
	 */
	public function toString(): string;
}
