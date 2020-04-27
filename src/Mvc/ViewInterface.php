<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\StringContainerInterface;

/**
 * Represents the interface of all views.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ViewInterface
{
	/**
	 * Gets the name of the view group the view belongs to.
	 * @return string The name of the view group the view belongs to.
	 */
	public function getGroupName(): string;

	/**
	 * Adds a view to the view.
	 * @param ViewInterface $view The view to add to the view.
	 */
	public function addView( ViewInterface $view ): void;

	/**
	 * Adds a list of views to the view.
	 * @param ViewInterface[] $views The list of views to add to the view.
	 */
	public function addViews( ViewInterface...$views ): void;

	/**
	 * Renders the view.
	 * @return StringContainerInterface The rendered view content.
	 */
	public function render(): StringContainerInterface;

	/**
	 * Renders the view and prints it.
	 */
	public function renderAndPrint(): void;

	/**
	 * Renders a group of views of the view.
	 * @param string $groupName The name of the group of views to render.
	 * @return StringContainerInterface The rendered content of the group of views.
	 */
	public function renderGroup( string $groupName ): StringContainerInterface;

	/**
	 * Renders a group of views of the view and prints them.
	 * @param string $groupName The name of the group of views to render.
	 */
	public function renderGroupAndPrint( string $groupName ): void;
}
