<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Annotations;

use CodeKandis\Pharty\Base\RuntimeException;

/**
 * Represents an exception if an annotation reader cannot be instantiated.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class AnnotationReaderInstantiationFailedException extends RuntimeException
{
}
