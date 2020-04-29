<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

use function strlen;

/**
 * Represents a string container.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class StringContainer implements StringContainerInterface
{
	/**
	 * Stores the content of the string container.
	 * @var string
	 */
	private string $content;

	/**
	 * Constructor method.
	 * @param string $content The content of the string container.
	 */
	public function __construct( string $content )
	{
		$this->content = $content;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLength(): int
	{
		return strlen( $this->content );
	}

	/**
	 * {@inheritdoc}
	 */
	public function addContent( string $content ): void
	{
		$this->content .= $content;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addContainer( StringContainerInterface $container ): void
	{
		$this->content .= $container->getContent();
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString(): string
	{
		return $this->getContent();
	}

	/**
	 * {@inheritdoc}
	 */
	public function toString(): string
	{
		return $this->getContent();
	}
}
