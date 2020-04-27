<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Base\LogicException;

/**
 * Represents an exception if a class is not marked as a serialization contract.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class NotASerializationContractException extends LogicException
{
}
