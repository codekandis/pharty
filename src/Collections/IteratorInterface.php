<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Collections;

use Countable;
use Iterator;

/**
 * Represents the interface of all iterable lists.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface IteratorInterface extends Countable, Iterator
{
	/**
	 * Gets the number of elements of the list.
	 * @return int The number of elements of the list.
	 */
	public function count(): int;

	/**
	 * Gets the current element of the list.
	 * @return mixed The current element of the list.
	 */
	public function current();

	/**
	 * Sets the pointer of the list to the next element if it is not set on the last element.
	 */
	public function next(): void;

	/**
	 * Gets the index of the current element of the list.
	 * @return int The index of the current element of the list.
	 */
	public function key(): int;

	/**
	 * Sets the pointer of the internal list to the first element;
	 */
	public function rewind(): void;

	/**
	 * Determines if there is an element right at the position of the pointer in the internal list.
	 * @return bool True if there is an element right at the position of the pointer in the internal list.
	 */
	public function valid(): bool;
}
