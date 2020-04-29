<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Base\LogicException;

/**
 * Represents an exception if a serialization contract class has no properties marked as serialization contract property.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SerializationContractHasNoPropertiesException extends LogicException
{
}
