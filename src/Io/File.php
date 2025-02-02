<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use function filesize;
use function mime_content_type;
use function sprintf;
use function unlink;

/**
 * Represents a file system file entry
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class File extends FileSystemEntry implements FileInterface
{
	/**
	 * Represents the error message if the file does not exist.
	 * @var string
	 */
	protected const ERROR_FILE_DOES_NOT_EXIST = 'The file \'%s\' does not exist.';

	/**
	 * Represents the error message if the file is not readable.
	 * @var string
	 */
	protected const ERROR_FILE_IS_NOT_READABLE = 'The file \'%s\' is not readable.';

	/**
	 * Represents the error message if the file is not writable.
	 * @var string
	 */
	protected const ERROR_FILE_IS_NOT_WRITABLE = 'The file \'%s\' is not writable.';

	/**
	 * Represents the error message if the file is not deletable.
	 * @var string
	 */
	protected const ERROR_FILE_IS_NOT_DELETABLE = 'The file \'%s\' is not deletable.';

	/**
	 * @inheritDoc
	 */
	public function exists(): bool
	{
		return parent::exists() && $this->isFile();
	}

	/**
	 * @inheritDoc
	 */
	public function delete(): void
	{
		if ( false === $this->exists() )
		{
			throw new FileNotFoundException(
				sprintf(
					static::ERROR_FILE_DOES_NOT_EXIST,
					$this->getPath()->toString()
				)
			);
		}
		if ( false === $this->isWritable() )
		{
			throw new FileNotWritableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_WRITABLE,
					$this->getPath()->toString()
				)
			);
		}
		if ( false === unlink( $this->getPath()->toString() ) )
		{
			throw new FileNotDeletableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_DELETABLE,
					$this->getPath()->toString()
				)
			);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getSize(): int
	{
		if ( false === $this->exists() )
		{
			throw new FileNotFoundException(
				sprintf(
					static::ERROR_FILE_DOES_NOT_EXIST,
					$this->getPath()->toString()
				)
			);
		}
		if ( false === $this->isReadable() )
		{
			throw new FileNotReadableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_READABLE,
					$this->getPath()->toString()
				)
			);
		}

		return filesize( $this->getPath()->toString() );
	}

	/**
	 * @inheritDoc
	 */
	public function getMimeType(): string
	{
		return mime_content_type( $this->getPath()->toString() );
	}
}
