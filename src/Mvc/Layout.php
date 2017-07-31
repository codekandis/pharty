<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use Closure;
use CodeKandis\Pharty\Collections\Vector;
use CodeKandis\Pharty\Data\StringContainer;
use CodeKandis\Pharty\Data\StringContainerInterface;
use CodeKandis\Pharty\Mvc\LayoutPreProcessors\LayoutPreProcessorInterface;
use function ob_get_clean;
use function ob_start;

/**
 * Represents a layout.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class Layout implements LayoutInterface
{
	/**
	 * Stores the path of the layout
	 * @var string
	 */
	private string $path;

	/**
	 * Stores the data the layout needs to render.
	 * @var null|mixed
	 */
	private $data;

	/**
	 * Stores the preprocessor of the layout.
	 * @var null|LayoutPreProcessorInterface
	 */
	private ?LayoutPreProcessorInterface $preProcessor;

	/**
	 * Stores the views of the layout.
	 * @var Vector
	 */
	private Vector $views;

	/**
	 * Constructor method.
	 * @param string $path The path of the layout.
	 * @param null|mixed $data The data the layout needs to render.
	 * @param null|LayoutPreProcessorInterface $preProcessor The preprocessor of the layout.
	 */
	public function __construct( string $path, $data = null, ?LayoutPreProcessorInterface $preProcessor = null )
	{
		$this->path         = $path;
		$this->preProcessor = $preProcessor;
		$this->views        = new Vector();
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
	public function addViews( ViewInterface ...$views ): void
	{
		foreach ( $views as $view )
		{
			$this->addView( $view );
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function render(): StringContainerInterface
	{
		$anonymousRenderer = static function ( string $path, LayoutInterface $layout, $data )
		{
			ob_start();
			require $path;

			return new StringContainer( ob_get_clean() );
		};
		$renderedContent   = Closure::bind( $anonymousRenderer, null )( $this->path, $this, $this->data );
		if ( null !== $this->preProcessor )
		{
			$this->preProcessor->execute( $renderedContent );
		}

		return $renderedContent;
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
		/* @var ViewInterface $viewFetched */
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
