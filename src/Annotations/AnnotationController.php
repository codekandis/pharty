<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Annotations;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use function get_class;
use function spl_autoload_functions;
use function sprintf;

/**
 * Represents an annotation controller.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class AnnotationController implements AnnotationControllerInterface
{
	/**
	 * Represents the error message if the annotation reader instantiation has been failed.
	 * @var string
	 */
	protected const ERROR_ANNOTATION_READER_INSTANTIATION_FAILED = '[%s] %s';

	/**
	 * Stores the Doctrine annotation reader.
	 * @var AnnotationReader
	 */
	private AnnotationReader $annotationReader;

	/**
	 * Constructor method.
	 */
	public function __construct()
	{
		$this->initAutoLoading();
	}

	/**
	 * Registers the autoloaders already registered in the SPL autoloader stack in the Doctrine annotation registry.
	 */
	private function initAutoLoading(): void
	{
		foreach ( spl_autoload_functions() as $autoLoaderFetched )
		{
			AnnotationRegistry::registerLoader( $autoLoaderFetched );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getAnnotationReader(): AnnotationReader
	{
		try
		{
			return $this->annotationReader ?? $this->annotationReader = new AnnotationReader();
		}
		catch ( AnnotationException $exception )
		{
			throw new AnnotationReaderInstantiationFailedException(
				sprintf(
					static::ERROR_ANNOTATION_READER_INSTANTIATION_FAILED,
					get_class( $exception ),
					$exception->getMessage()
				),
				0,
				$exception
			);
		}
	}
}
