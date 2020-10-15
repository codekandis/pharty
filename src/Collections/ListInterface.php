<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Collections;

/**
 * Represents the interface of all lists.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ListInterface extends ImmutableListInterface
{
	/**
	 * Removes all elements from the list.
	 */
	public function clear(): void;

	/**
	 * Adds an element to the list.
	 * @param mixed $element The element to add to the list.
	 */
	public function add( $element ): void;

	/**
	 * Inserts a new element at a specified index.
	 * @param int $index The index to insert the new element at.
	 * @param mixed $element The new element to insert.
	 */
	public function insert( int $index, $element ): void;

	/**
	 * Removes an element from the list.
	 * @param mixed $element The element to remove.
	 * @throws ElementNotFoundException The element does not exist.
	 */
	public function remove( $element ): void;
}
