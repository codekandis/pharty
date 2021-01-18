<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use CodeKandis\Pharty\Data\ConverterInterface;
use function file_get_contents;
use function sprintf;

/**
 * Represents the standard file reader handling a file.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class FileReader implements FileReaderInterface
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
	 * Stores the file the file reader is handling.
	 * @var FileInterface
	 */
	private FileInterface $file;

	/**
	 * Stores the converter to convert the read content.
	 * @var ?ConverterInterface
	 */
	private ?ConverterInterface $converter;

	/**
	 * Constructor method.
	 * @param FileInterface $file The file the file reader is handling.
	 * @param ?ConverterInterface $converter The file read converter to convert the read file content, null otherwise.
	 * @throws DirectoryNotFoundException The directory of the file does not exist.
	 * @throws FileNotFoundException The file does not exist.
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
		if ( false === $file->exists() )
		{
			throw new FileNotFoundException(
				sprintf(
					static::ERROR_FILE_DOES_NOT_EXIST,
					$file->getPath()->toString()
				)
			);
		}
		$this->file      = $file;
		$this->converter = $converter;
	}

	/**
	 * @inheritDoc
	 */
	public function readAll(): string
	{
		$filePath      = $this->file->getPath();
		$directoryPath = new Path( $filePath->getDirectoryName() );
		if ( false === ( new Directory( $directoryPath ) )->isReadable() )
		{
			throw new DirectoryNotReadableException(
				sprintf(
					static::ERROR_DIRECTORY_IS_NOT_READABLE,
					$directoryPath->toString()
				)
			);
		}
		if ( false === $this->file->isReadable() )
		{
			throw new FileNotReadableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_READABLE,
					$filePath->toString()
				)
			);
		}
		$result = file_get_contents( $filePath->toString() );
		if ( false === $result )
		{
			throw new FileNotReadableException(
				sprintf(
					static::ERROR_FILE_IS_NOT_READABLE,
					$filePath->toString()
				)
			);
		}

		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function readAllConverted()
	{
		return null === $this->converter
			? $this->readAll()
			: $this->converter->convert( $this->readAll() );
	}
}
