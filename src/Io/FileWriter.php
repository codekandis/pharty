<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use CodeKandis\Pharty\Data\ConverterInterface;
use function file_put_contents;
use function sprintf;

/**
 * Represents the standard file writer handling a file.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class FileWriter implements FileWriterInterface
{
	/**
	 * Represents the error message if the directory does not exist.
	 * @var string
	 */
	protected const ERROR_DIRECTORY_DOES_NOT_EXIST = 'The directory \'%s\' does not exist.';

	/**
	 * Represents the error message if the directory is not writable.
	 * @var string
	 */
	protected const ERROR_DIRECTORY_IS_NOT_WRITABLE = 'The directory \'%s\' is not writable.';

	/**
	 * Represents the error message if the file is not writable.
	 * @var string
	 */
	protected const ERROR_FILE_IS_NOT_WRITABLE = 'The file \'%s\' is not writable.';

	/**
	 * Stores the file the file writer is handling.
	 * @var FileInterface
	 */
	private FileInterface $file;

	/**
	 * Stores the converter to convert the content to write.
	 * @var null|ConverterInterface
	 */
	private ?ConverterInterface $converter;

	/**
	 * Constructor method.
	 * @param FileInterface $file The file the file writer is handling.
	 * @param null|ConverterInterface $converter The file write converter to convert the file content to write, null otherwise.
	 * @throws DirectoryNotFoundException The directory of the file does not exist.
	 */
	public function __construct( FileInterface $file, ?ConverterInterface $converter = null )
	{
		$directoryPath = new Path( $file->getPath()->getDirectoryName() );
		if ( false === ( new Directory( $directoryPath ) )->exists() )
		{
			throw new DirectoryNotFoundException(
				sprintf(
					static::ERROR_DIRECTORY_DOES_NOT_EXIST,
					$directoryPath->toString()
				)
			);
		}
		$this->file      = $file;
		$this->converter = $converter;
	}

	/**
	 * {@inheritdoc}
	 */
	public function writeAll( string $content ): void
	{
		$filePath      = $this->file->getPath();
		$directoryPath = new Path( $filePath->getDirectoryName() );
		if ( false === ( new Directory( $directoryPath ) )->isWritable() )
		{
			throw new DirectoryNotWritableException(
				sprintf(
					static::ERROR_DIRECTORY_IS_NOT_WRITABLE,
					$directoryPath->toString()
				)
			);
		}
		if ( false === file_put_contents( $filePath->toString(), $content ) )
		{
			throw new FileNotWritableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_WRITABLE,
					$filePath->toString()
				)
			);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function writeAllConverted( $content ): void
	{
		$this->writeAll(
			null === $this->converter
				? $content
				: $this->converter->convert( $content )
		);
	}
}
