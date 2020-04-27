<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Annotations\AbstractPropertyAttribute;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Represents a serialization property attribute to mark a property as serializable.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 * @Annotation
 * @Target("PROPERTY")
 */
class SerializationPropertyAttribute extends AbstractPropertyAttribute
{
	/**
	 * Stores the name of the serialization property to serialize.
	 * @var string
	 */
	public string $name = '';

	/**
	 * Stores the type of the serialization property to serialize.
	 * @var string
	 */
	public string $type = '';
}
