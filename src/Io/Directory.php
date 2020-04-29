<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use function array_diff;
use function rmdir;
use function scandir;
use function sprintf;
use const DIRECTORY_SEPARATOR;
use const SCANDIR_SORT_ASCENDING;

/**
 * Represents a file system directory entry.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Directory extends FileSystemEntry implements DirectoryInterface
{
	/**
	 * Represents the error message if the directory does not exist.
	 * @var string
	 */
	protected const ERROR_DIRECTORY_DOES_NOT_EXIST = 'The directory \'%s\' does not exist.';

	/**
	 * Represents the error message if the directory is not readable.
	 * @var string
	 */
	protected const ERROR_DIRECTORY_IS_NOT_READABLE = 'The directory \'%s\' is not readable.';

	/**
	 * Represents the error message if the directory is not deletable.
	 * @var string
	 */
	protected const ERROR_DIRECTORY_IS_NOT_DELETABLE = 'The directory \'%s\' is not deletable.';

	/**
	 * {@inheritdoc}
	 */
	public function exists(): bool
	{
		return parent::exists() && $this->isDirectory();
	}

	/**
	 * {@inheritdoc}
	 */
	public function fetchFileSystemEntries(): iterable
	{
		if ( false === $this->exists() )
		{
			throw new DirectoryNotFoundException(
				sprintf(
					static::ERROR_DIRECTORY_DOES_NOT_EXIST,
					$this->getPath()->toString()
				)
			);
		}
		if ( false === $this->isReadable() )
		{
			throw new DirectoryNotReadableException(
				sprintf(
					static::ERROR_DIRECTORY_IS_NOT_READABLE,
					$this->getPath()->toString()
				)
			);
		}
		$directoryEntriesFiltered =
			array_diff(
				scandir(
					$this->getPath()->toString(),
					SCANDIR_SORT_ASCENDING
				),
				[
					'.',
					'..',
				]
			);
		foreach ( $directoryEntriesFiltered as $directoryEntryFetched )
		{
			yield new FileSystemEntry(
				new Path( $this->getPath()->toString() . DIRECTORY_SEPARATOR . $directoryEntryFetched )
			);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function fetchFiles(): iterable
	{
		/* @var FileSystemEntryInterface $fileSystemEntryFetched */
		foreach ( $this->fetchFileSystemEntries() as $fileSystemEntryFetched )
		{
			if ( false === $fileSystemEntryFetched->isFile() )
			{
				yield new File( $fileSystemEntryFetched->getPath() );
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function fetchDirectories(): iterable
	{
		/* @var FileSystemEntryInterface $fileSystemEntryFetched */
		foreach ( $this->fetchFileSystemEntries() as $fileSystemEntryFetched )
		{
			if ( false === $fileSystemEntryFetched->isDirectory() )
			{
				yield new static( $fileSystemEntryFetched->getPath() );
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(): void
	{
		/* @var FileSystemEntryInterface $fileSystemEntryFetched */
		foreach ( $this->fetchFileSystemEntries() as $fileSystemEntryFetched )
		{
			if ( true === $fileSystemEntryFetched->isFile() )
			{
				( new File( $fileSystemEntryFetched->getPath() ) )
					->delete();
				continue;
			}
			if ( true === $fileSystemEntryFetched->isDirectory() )
			{
				$fetchedDirectoryPath = $fileSystemEntryFetched->getPath();
				( new static( $fetchedDirectoryPath ) )
					->delete();
			}
		}
		if ( false === rmdir( $this->getPath()->toString() ) )
		{
			throw new DirectoryNotDeletableException(
				sprintf(
					static::ERROR_DIRECTORY_IS_NOT_DELETABLE,
					$this->getPath()->toString()
				)
			);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSize(): int
	{
		$size = 0;
		/* @var FileSystemEntryInterface $fileSystemEntryFetched */
		foreach ( $this->fetchFileSystemEntries() as $fileSystemEntryFetched )
		{
			if ( true === $fileSystemEntryFetched->isFile() )
			{
				$size += ( new File( $fileSystemEntryFetched->getPath() ) )
					->getSize();
				continue;
			}
			if ( true === $fileSystemEntryFetched->isDirectory() )
			{
				$size += ( new static( $fileSystemEntryFetched->getPath() ) )
					->getSize();
			}
		}

		return $size;
	}
}
