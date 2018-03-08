<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Represents the interface of all annotation controllers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface AnnotationControllerInterface
{
	/**
	 * Gets the Doctrine annotation reader.
	 * @return AnnotationReader The Doctrine annotation reader.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 */
	public function getAnnotationReader(): AnnotationReader;
}
