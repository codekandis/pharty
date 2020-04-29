<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Base\LogicException;

/**
 * Represents an exception if an error occures during serialization or deserialization.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SerializerException extends LogicException
{
}
