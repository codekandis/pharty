<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

/**
 * Represents the interface of all file system entries.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FileSystemEntryInterface
{
	/**
	 * Gets the path of the file system entry.
	 * @return PathInterface The path of the file system entry.
	 */
	public function getPath(): PathInterface;

	/**
	 * Gets the name of the file system entry.
	 * @return string The name of the file system entry.
	 */
	public function getName(): string;

	/**
	 * Determines if the file system entry exists in the file system.
	 * @return bool True if the file system entry exists in the file system, false otherwise.
	 */
	public function exists(): bool;

	/**
	 * Determines if the file system entry is a file.
	 * @return bool True if the file system entry is a file, false otherwise.
	 */
	public function isFile(): bool;

	/**
	 * Determines if the file system entry is a directory.
	 * @return bool True if the file system entry is a directory, false otherwise.
	 */
	public function isDirectory(): bool;

	/**
	 * Determines if the file system entry is readable.
	 * @return bool True if the file system entry is readable, false otherwise.
	 */
	public function isReadable(): bool;

	/**
	 * Determines if the file system entry is writable.
	 * @return bool True if the file system entry is writable, false otherwise.
	 */
	public function isWritable(): bool;
}
