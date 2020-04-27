<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\StringContainerInterface;

/**
 * Represents the interface of all layouts.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LayoutInterface
{
	/**
	 * Adds a view to the layout.
	 * @param ViewInterface $view The view to add to the layout.
	 */
	public function addView( ViewInterface $view ): void;

	/**
	 * Adds a list of views to the layout.
	 * @param ViewInterface[] $views The list  of views to add to the layout.
	 */
	public function addViews( ViewInterface...$views ): void;

	/**
	 * Renders the layout.
	 * @return StringContainerInterface The rendered layout content.
	 */
	public function render(): StringContainerInterface;

	/**
	 * Prints the rendered layout.
	 */
	public function renderAndPrint(): void;

	/**
	 * Renders a group of views of the layout.
	 * @param string $groupName The name of the group of views to render.
	 * @return StringContainerInterface The rendered content of the group of views.
	 */
	public function renderGroup( string $groupName ): StringContainerInterface;

	/**
	 * Renders a group of views of the layout and prints them.
	 * @param string $groupName The name of the group of views to render.
	 */
	public function renderGroupAndPrint( string $groupName ): void;
}
