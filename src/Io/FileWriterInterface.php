<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

/**
 * Represents the interface of all file writers handling a file.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FileWriterInterface
{
	/**
	 * Writes the whole content of the file.
	 * @param string $content The content of the file.
	 * @throws DirectoryNotWritableException The directory of the file is not writable.
	 * @throws FileNotWritableException The file is not writable.
	 */
	public function writeAll( string $content ): void;

	/**
	 * Writes the content of the file converted by the set content converter if one has been registered, the unconverted content otherwise.
	 * @param mixed $content The content of the file.
	 * @throws DirectoryNotWritableException The directory of the file is not writable.
	 * @throws FileNotWritableException The file is not writable.
	 */
	public function writeAllConverted( $content ): void;
}
