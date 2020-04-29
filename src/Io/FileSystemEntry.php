<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use function file_exists;
use function is_dir;
use function is_file;
use function is_readable;
use function is_writable;

/**
 * Represents a file system entry.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class FileSystemEntry implements FileSystemEntryInterface
{
	/**
	 * Stores the path of the file system entry.
	 * @var PathInterface
	 */
	private PathInterface $path;

	/**
	 * Constructor method.
	 * @param PathInterface The path of the file system entry.
	 */
	public function __construct( PathInterface $path )
	{
		$this->path = $path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPath(): PathInterface
	{
		return $this->path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName(): string
	{
		return $this->path->getBaseName();
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists(): bool
	{
		return file_exists( $this->path->toString() );
	}

	/**
	 * {@inheritdoc}
	 */
	public function isFile(): bool
	{
		return is_file( $this->path->toString() );
	}

	/**
	 * {@inheritdoc}
	 */
	public function isDirectory(): bool
	{
		return is_dir( $this->path->toString() );
	}

	/**
	 * {@inheritdoc}
	 */
	public function isReadable(): bool
	{
		return is_readable( $this->path->toString() );
	}

	/**
	 * {@inheritdoc}
	 */
	public function isWritable(): bool
	{
		return is_writable( $this->path->toString() );
	}
}
