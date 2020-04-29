<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Annotations\AbstractClassAttribute;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Represents a serialization contract attribute to mark a class as serializable.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 * @Annotation
 * @Target("CLASS")
 */
class SerializationContractAttribute extends AbstractClassAttribute
{
	/**
	 * Stores if the resulting serialization is represented by a single serialized value instead of the whole serialized class.
	 * @var bool
	 */
	public bool $serializeSinglePropertyOnly = false;

	/**
	 * Stores the type of the collection elements to serialize.
	 * @var string
	 */
	public string $collectedType = '';
}
