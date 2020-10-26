<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use function sprintf;

/**
 * Represents a HTTP header.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class HttpHeader implements HttpHeaderInterface
{
	/**
	 * Stores the name of the header.
	 * @var string The name of the header.
	 */
	private string $name;

	/**
	 * Stores the value of the header.
	 * @var string The value of the header.
	 */
	private string $value;

	/**
	 * Constructor method.
	 * @param string $name The name of the header.
	 * @param string $value The value of the header.
	 */
	public function __construct( string $name, string $value )
	{
		$this->name  = ( new HttpHeaderNameSanitizer() )
			->sanitize( $name );
		$this->value = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function __toString(): string
	{
		return sprintf(
			'%s: %s',
			$this->name,
			$this->value
		);
	}

	/**
	 * @inheritDoc
	 */
	public function toString(): string
	{
		return $this->__toString();
	}
}
