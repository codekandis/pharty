<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Io;

use function pathinfo;
use const DIRECTORY_SEPARATOR;
use const PATHINFO_BASENAME;
use const PATHINFO_DIRNAME;
use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;

/**
 * Represents a path.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Path implements PathInterface
{
	/**
	 * Stores the base name of the path.
	 * @var string
	 */
	private string $baseName;

	/**
	 * Stores the directory name of the path.
	 * @var string
	 */
	private string $directoryName;

	/**
	 * Stores the name of the path.
	 * @var string
	 */
	private string $name;

	/**
	 * Stores the extension of the path.
	 * @var string
	 */
	private string $extension;

	/**
	 * Constructor method.
	 * @param string $path The wrapped path.
	 */
	public function __construct( string $path )
	{
		$pathInformation     = pathinfo( $path, PATHINFO_BASENAME | PATHINFO_DIRNAME | PATHINFO_FILENAME | PATHINFO_EXTENSION );
		$this->baseName      = $pathInformation[ 'basename' ] ?? '';
		$this->directoryName = $pathInformation[ 'dirname' ] ?? '';
		$this->name          = $pathInformation[ 'filename' ] ?? '';
		$this->extension     = $pathInformation[ 'extension' ] ?? '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBaseName(): string
	{
		return $this->baseName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDirectoryName(): string
	{
		return $this->directoryName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtension(): string
	{
		return $this->extension;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString(): string
	{
		return $this->directoryName . DIRECTORY_SEPARATOR . $this->baseName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function toString(): string
	{
		return $this->directoryName . DIRECTORY_SEPARATOR . $this->baseName;
	}
}
