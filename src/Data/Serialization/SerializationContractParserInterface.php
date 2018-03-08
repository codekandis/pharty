<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Annotations\AnnotationReaderInstantiationFailedException;

/**
 * Represents the interface of all serialization contract parsers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface SerializationContractParserInterface
{
	/**
	 * Parses an object if it is a valid serialization contract.
	 * @return ParsedSerializationContractInterface The parsed serialization contract.
	 * @throws SerializationContractNotFoundException The serialization contract does not exist.
	 * @throws AnnotationReaderInstantiationFailedException The annotation reader cannot be instantiated.
	 * @throws NotASerializationContractException The class is not marked as a serialization contract.
	 * @throws SerializationContractHasNoPropertiesException The serialization contract does not have any properties marked as serialization property.
	 * @throws SerializationContractHasTooMuchPropertiesException The serialization contract is marked as serialize single property only but has more than one properties marked for serialization.
	 */
	public function parse(): ParsedSerializationContractInterface;
}
