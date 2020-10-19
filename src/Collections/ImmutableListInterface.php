<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Collections;

use Closure;

/**
 * Represents the interface of all immutable lists.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ImmutableListInterface extends IteratorInterface
{
	/**
	 * Determines if the list already contains a passed element.
	 * @param mixed $element The element to check if it already exists in the list.
	 * @return bool True if the list already contains the passed element, false otherwise.
	 */
	public function contains( $element ): bool;

	/**
	 * Determines the index of an element.
	 * @param mixed $element The element to find its index.
	 * @return int The index of the element if found, -1 otherwise.
	 */
	public function indexOf( $element ): int;

	/**
	 * Gets an element of the list by its zero based index.
	 * @param int $index The zero based index of the element to get.
	 * @return mixed The element of the list at the specified index.
	 * @throws OutOfBoundsException The specified index is out of bounds.
	 */
	public function elementAt( int $index );

	/**
	 * Gets the first element of the list matching a passed predicate.
	 * @param Closure $predicate The predicate defining which element to find.
	 * @return null|mixed The first element matching the passed predicate, null otherwise.
	 */
	public function find( Closure $predicate );

	/**
	 * Gets a list of elements of the list matching a passed predicate.
	 * @param Closure $predicate The predicate defining which elements to find.
	 * @return self The list of elements matching the passed predicate.
	 */
	public function findAll( Closure $predicate ): self;

	/**
	 * Gets a new list of all elements transformed by a passed transformator.
	 * @param Closure $transformator The transformator transforms all elements of the list into new elements.
	 * @return self The new list of all elements transformed by the passed transformator.
	 */
	public function transform( Closure $transformator ): self;

	/**
	 * Gets the array representation of all elements of the list.
	 * @return array The array representation of all elements of the list.
	 */
	public function toArray(): array;
}
