<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data;

use function array_key_exists;
use function sprintf;

/**
 * Represents an array accessor managing an array by reference.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ArrayAccessor implements ArrayAccessorInterface
{
	/**
	 * Represents the error message if a key does not exist.
	 * @var string
	 */
	protected const ERROR_KEY_DOES_NOT_EXIST = 'The key \'%s\' does not exist.';

	/**
	 * Stores the array to access.
	 * @var mixed[]
	 */
	private array $data;

	/**
	 * Constructor method.
	 * @param mixed[] $data The array to access.
	 */
	public function __construct( array &$data )
	{
		$this->data = &$data;
	}

	/**
	 * @inheritDoc
	 */
	public function has( string $key ): bool
	{
		return array_key_exists( $key, $this->data );
	}

	/**
	 * @inheritDoc
	 */
	public function get( string $key )
	{
		if ( false === array_key_exists( $key, $this->data ) )
		{
			throw new ArrayKeyNotFoundException(
				sprintf(
					static::ERROR_KEY_DOES_NOT_EXIST,
					$key
				)
			);
		}

		return $this->data[ $key ];
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaulted( string $key, $default )
	{
		return false === array_key_exists( $key, $this->data )
			? $default
			: $this->data[ $key ];
	}

	/**
	 * @inheritDoc
	 */
	public function set( string $key, $value ): void
	{
		$data         = &$this->data;
		$data[ $key ] = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function unset( string $key ): void
	{
		if ( false === array_key_exists( $key, $this->data ) )
		{
			throw new ArrayKeyNotFoundException(
				sprintf(
					static::ERROR_KEY_DOES_NOT_EXIST,
					$key
				)
			);
		}
		$data = &$this->data;
		unset ( $data[ $key ] );
	}
}
