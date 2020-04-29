<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use Closure;
use CodeKandis\Pharty\Collections\Set;
use CodeKandis\Pharty\Data\StringContainer;
use CodeKandis\Pharty\Data\StringContainerInterface;
use function ob_get_clean;
use function ob_start;

/**
 * Represents a view.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class View implements ViewInterface
{
	/**
	 * Stores the name of the view group the view belongs to.
	 * @var string
	 */
	private string $groupName;

	/**
	 * Stores the path of the view.
	 * @var string
	 */
	private string $path;

	/**
	 * Stores the data the view needs to render.
	 * @var null|mixed
	 */
	private $data;

	/**
	 * Stores the views of the view.
	 * @var Set
	 */
	private Set $views;

	/**
	 * Constructor method.
	 * @param string $groupName The name of the view group the view belongs to.
	 * @param string $path The path of the view.
	 * @param null|mixed $data The data the view needs to render.
	 */
	public function __construct( string $groupName, string $path, $data = null )
	{
		$this->groupName = $groupName;
		$this->path      = $path;
		$this->data      = $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getGroupName(): string
	{
		return $this->groupName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addView( ViewInterface $view ): void
	{
		$this->views->add( $view );
	}

	/**
	 * {@inheritdoc}
	 */
	public function addViews( ViewInterface...$views ): void
	{
		foreach ( $views as $viewwFetched )
		{
			$this->addView( $viewwFetched );
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function render(): StringContainerInterface
	{
		$anonymousRenderer = static function ( string $path, ViewInterface $view, $data )
		{
			ob_start();
			require $path;

			return new StringContainer( ob_get_clean() );
		};

		return Closure::bind( $anonymousRenderer, null )( $this->path, $this, $this->data );
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderAndPrint(): void
	{
		echo $this->render()->getContent();
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderGroup( string $groupName ): StringContainerInterface
	{
		$groupContents = new StringContainer( '' );
		$predicate     = static function ( ViewInterface $value ) use ( $groupName )
		{
			return $value->getGroupName() === $groupName;
		};
		/**
		 * @var ViewInterface $viewFetched
		 */
		foreach ( $this->views->findAll( $predicate ) as $viewFetched )
		{
			$groupContents->addContainer( $viewFetched->render() );
		}

		return $groupContents;
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderGroupAndPrint( string $groupName ): void
	{
		echo $this->renderGroup( $groupName )->getContent();
	}
}
