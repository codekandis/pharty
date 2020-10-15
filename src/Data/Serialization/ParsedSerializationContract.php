<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Data\Serialization;

use CodeKandis\Pharty\Collections\ImmutableListInterface;
use CodeKandis\Pharty\Collections\Set;
use ReflectionClass;

/**
 * Represents a parsed serialization contract.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ParsedSerializationContract implements ParsedSerializationContractInterface
{
	/**
	 * Stores the reflected serialization contract.
	 * @var ReflectionClass
	 */
	private ReflectionClass $reflectedClass;

	/**
	 * Stores the serialization contract attribute of the parsed serialization contract.
	 * @var SerializationContractAttribute
	 */
	private SerializationContractAttribute $contractAttribute;

	/**
	 * Stores the list of parsed serialization properties of the parsed contract.
	 * @var ImmutableListInterface
	 */
	private ImmutableListInterface $parsedProperties;

	/**
	 * Constructor method.
	 * @param ReflectionClass $reflectedClass The reflected serialization property of the serialization contract.
	 * @param SerializationContractAttribute $contractAttribute The serialization contract attribute of the parsed serialization contract.
	 */
	public function __construct( ReflectionClass $reflectedClass, SerializationContractAttribute $contractAttribute )
	{
		$this->reflectedClass    = $reflectedClass;
		$this->contractAttribute = $contractAttribute;
	}

	/**
	 * @inheritDoc
	 */
	public function getReflectedClass(): ReflectionClass
	{
		return $this->reflectedClass;
	}

	/**
	 * @inheritDoc
	 */
	public function getContractName(): string
	{
		return $this->reflectedClass->getName();
	}

	/**
	 * @inheritDoc
	 */
	public function getContractAttribute(): SerializationContractAttribute
	{
		return $this->contractAttribute;
	}

	/**
	 * @inheritDoc
	 */
	public function getParsedProperties(): ImmutableListInterface
	{
		return $this->parsedProperties ?? $this->parsedProperties = new Set();
	}

	/**
	 * @inheritDoc
	 */
	public function setParsedProperties( ImmutableListInterface $parsedProperties ): void
	{
		$this->parsedProperties = $parsedProperties;
	}
}
