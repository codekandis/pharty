<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Io\FileNotFoundException;

/**
 * Represents an exception if a serialization contract does not exist.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SerializationContractNotFoundException extends FileNotFoundException
{
}
