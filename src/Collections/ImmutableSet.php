<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Collections;

use Closure;
use CodeKandis\Pharty\Data\Serialization\SerializationContractAttribute;
use CodeKandis\Pharty\Data\Serialization\SerializationPropertyAttribute;
use function count;
use function in_array;
use function sprintf;

/**
 * Represents an immutable list of various elements. A set contains elements strictly unique by their type and their value.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 * @SerializationContractAttribute(serializeSinglePropertyOnly=true)
 */
class ImmutableSet implements ImmutableListInterface
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
	 * Represents the error message if an element already exists.
	 * @var string
	 */
	protected const ERROR_ELEMENT_ALREADY_EXISTS = 'The element has already been added.';

	/**
	 * Stores the position of the internal array pointer.
	 * @var int
	 */
	private int $position = 0;

	/**
	 * Stores the internal list of elements.
	 * @var array
	 * @SerializationPropertyAttribute()
	 *
	 */
	protected array $elements;

	/**
	 * Constructor method.
	 * @param array The initial elements.
	 * @throws DuplicateElementException The element has already been added.
	 */
	public function __construct( array $elements = [] )
	{
		$this->elements = [];
		foreach ( $elements as $element )
		{
			$this->add( $element );
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function count(): int
	{
		return count( $this->elements );
	}

	/**
	 * {@inheritdoc}
	 */
	public function current()
	{
		return $this->elements[ $this->position ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function next(): void
	{
		$this->position++;
	}

	/**
	 * {@inheritdoc}
	 */
	public function key(): int
	{
		return $this->position;
	}

	/**
	 * {@inheritdoc}
	 */
	public function rewind(): void
	{
		$this->position = 0;
	}

	/**
	 * {@inheritdoc}
	 */
	public function valid(): bool
	{
		return $this->position < count( $this->elements );
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains( $element ): bool
	{
		return in_array( $element, $this->elements, true );
	}

	/**
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
	 */
	public function toArray(): array
	{
		return $this->elements;
	}

	/**
	 * Adds an element to the list.
	 * @param mixed $element The element to add to the list.
	 * @throws DuplicateElementException The element has already been added.
	 */
	private function add( $element ): void
	{
		if ( true === $this->contains( $element ) )
		{
			throw new DuplicateElementException( static::ERROR_ELEMENT_ALREADY_EXISTS );
		}
		$this->elements[] = $element;
	}
}
