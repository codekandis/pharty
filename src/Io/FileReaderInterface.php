<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

/**
 * Represents the interface of all file readers handling a file.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FileReaderInterface
{
	/**
	 * Reads the whole content of the file.
	 * @return string The content of the file.
	 * @throws DirectoryNotReadableException The directory of the file is not readable.
	 * @throws FileNotReadableException The file is not readable.
	 */
	public function readAll(): string;

	/**
	 * Reads the content of the file converted by the set file reader content converter if one has been registered, the unconverted content otherwise.
	 * @return mixed The content of the file converted by the registered converter if one has been registered, the unconverted content otherwise.
	 * @throws DirectoryNotReadableException The directory of the file is not readable.
	 * @throws FileNotReadableException The file is not readable.
	 */
	public function readAllConverted();
}
