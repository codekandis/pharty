<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Collections;

use Closure;
use CodeKandis\Pharty\Data\Serialization\SerializationContractAttribute;
use CodeKandis\Pharty\Data\Serialization\SerializationPropertyAttribute;
use function array_key_exists;
use function array_search;
use function array_splice;
use function array_values;
use function count;
use function in_array;
use function sprintf;

/**
 * Represents a list of elements. A vector contains non-unique elements.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 * @SerializationContractAttribute(serializeSinglePropertyOnly=true)
 */
class Vector implements ListInterface
{
	/**
	 * Represents the error message if an index is out of bounds while the list contains no elements.
	 * @var string
	 */
	protected const ERROR_LIST_CONTAINS_NO_ELEMENTS = 'The index \'%d\' is out of bounds: The list contains no elements.';

	/**
	 * Represents the error message if an index is out of bounds.
	 * @var string
	 */
	protected const ERROR_INDEX_OUT_OF_BOUNDS = 'The index \'%d\' is out of bounds: [0..%d] expected.';

	/**
	 * Represents the error message if an element does not exist.
	 * @var string
	 */
	protected const ERROR_ELEMENT_NOT_FOUND = 'The element does not exist.';

	/**
	 * Represents the error message if an element at a specified index does not exist.
	 * @var string
	 */
	protected const ERROR_ELEMENT_AT_INDEX_NOT_FOUND = 'The element at the index \'%d\' does not exist.';

	/**
	 * Stores the position of the internal array pointer.
	 * @var int
	 */
	private int $position = 0;

	/**
	 * Stores the internal list of elements.
	 * @var array
	 * @SerializationPropertyAttribute()
	 */
	protected array $elements;

	/**
	 * Constructor method.
	 * @param array The initial elements.
	 */
	public function __construct( array $elements = [] )
	{
		$this->elements = array_values( $elements );
	}

	/**
	 * @inheritDoc
	 */
	public function count(): int
	{
		return count( $this->elements );
	}

	/**
	 * @inheritDoc
	 */
	public function current()
	{
		return $this->elements[ $this->position ];
	}

	/**
	 * @inheritDoc
	 */
	public function next(): void
	{
		$this->position++;
	}

	/**
	 * @inheritDoc
	 */
	public function key(): int
	{
		return $this->position;
	}

	/**
	 * @inheritDoc
	 */
	public function rewind(): void
	{
		$this->position = 0;
	}

	/**
	 * @inheritDoc
	 */
	public function valid(): bool
	{
		return $this->position < count( $this->elements );
	}

	/**
	 * @inheritDoc
	 */
	public function contains( $element ): bool
	{
		return in_array( $element, $this->elements, true );
	}

	/**
	 * @inheritDoc
	 */
	public function indexOf( $element ): int
	{
		$index = array_search( $element, $this->elements, true );

		if ( false === $index )
		{
			return -1;
		}

		return $index;
	}

	/**
	 * @inheritDoc
	 */
	public function elementAt( int $index )
	{
		$count = count( $this->elements );
		if ( 0 === $count )
		{
			throw new OutOfBoundsException(
				sprintf(
					static::ERROR_LIST_CONTAINS_NO_ELEMENTS,
					$index
				)
			);
		}
		$upperBound = $count - 1;
		if ( 0 > $index || $upperBound < $index )
		{
			throw new OutOfBoundsException(
				sprintf(
					static::ERROR_INDEX_OUT_OF_BOUNDS,
					$index,
					$upperBound
				)
			);
		}

		return $this->elements[ $index ];
	}

	/**
	 * @inheritDoc
	 */
	public function find( Closure $predicate )
	{
		foreach ( $this->elements as $elementFetched )
		{
			if ( true === $predicate( $elementFetched ) )
			{
				return $elementFetched;
			}
		}

		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function findAll( Closure $predicate ): self
	{
		$elementsFound = [];
		foreach ( $this->elements as $elementFetched )
		{
			if ( true === $predicate( $elementFetched ) )
			{
				$elementsFound[] = $elementFetched;
			}
		}

		return new static( $elementsFound );
	}

	/**
	 * @inheritDoc
	 */
	public function transform( Closure $transformator ): self
	{
		$elementsTransformed = [];
		foreach ( $this->elements as $elementFetched )
		{
			$elementsTransformed[] = $transformator( $elementFetched );
		}

		return new static( $elementsTransformed );
	}

	/**
	 * @inheritDoc
	 */
	public function toArray(): array
	{
		return $this->elements;
	}

	/**
	 * @inheritDoc
	 */
	public function clear(): void
	{
		$this->elements = [];
	}

	/**
	 * @inheritDoc
	 */
	public function add( $element ): void
	{
		$this->elements[] = $element;
	}

	/**
	 * @inheritDoc
	 */
	public function insert( int $index, $element ): void
	{
		array_splice( $this->elements, $index, 0, [ $element ] );
	}

	/**
	 * @inheritDoc
	 */
	public function replace( $element, $replacement ): void
	{
		$index = $this->indexOf( $element );

		if ( -1 === $index )
		{
			throw new ElementNotFoundException( static::ERROR_ELEMENT_NOT_FOUND );
		}

		array_splice( $this->elements, $index, 1, [ $replacement ] );
	}

	/**
	 * @inheritDoc
	 */
	public function replaceAt( int $index, $replacement ): void
	{
		if ( false === array_key_exists( $index, $this->elements ) )
		{
			$message = sprintf(
				static::ERROR_ELEMENT_AT_INDEX_NOT_FOUND,
				$index
			);
			throw new ElementNotFoundException( $message );
		}

		$this->elements[ $index ] = $replacement;
	}

	/**
	 * @inheritDoc
	 */
	public function remove( $element ): void
	{
		$index = array_search( $element, $this->elements, true );
		if ( false === $index )
		{
			throw new ElementNotFoundException( static::ERROR_ELEMENT_NOT_FOUND );
		}
		unset ( $this->elements[ $index ] );
		$this->elements = array_values( $this->elements );
	}
}
