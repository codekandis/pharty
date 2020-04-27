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
	 * Adds an element to the list.
	 * @param mixed $element The element to add to the list.
	 */
	public function add( $element ): void;

	/**
	 * Removes an element from the list.
	 * @param mixed $element The element to remove.
	 * @throws ElementNotFoundException The element does not exist.
	 */
	public function remove( $element ): void;
}
