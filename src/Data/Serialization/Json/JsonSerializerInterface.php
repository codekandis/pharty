<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization\Json;

use CodeKandis\JsonCodec\JsonDecoderOptions;
use CodeKandis\JsonCodec\JsonEncoderOptions;
use CodeKandis\Pharty\Data\Serialization\DeserializationFailedException;
use CodeKandis\Pharty\Data\Serialization\SerializationFailedException;

/**
 * Represents the interface of all JSON serializers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface JsonSerializerInterface
{
	/**
	 * Serializes an object into a JSON string.
	 * @param mixed $data The object to serialize.
	 * @param ?JsonEncoderOptions $options The serialization options.
	 * @return string The serialized JSON string.
	 * @throws SerializationFailedException The serialization failed.
	 */
	public function serialize( $data, ?JsonEncoderOptions $options = null ): string;

	/**
	 * Deserializes a JSON string into an object.
	 * @param string $data The JSON string to deserialize.
	 * @param string $class The class name to deserialize into.
	 * @param ?JsonDecoderOptions $options The deserialization options.
	 * @return object The deserialized object.
	 * @throws DeserializationFailedException The deserialization failed.
	 */
	public function deserialize( string $data, string $class, ?JsonDecoderOptions $options = null ): object;
}
