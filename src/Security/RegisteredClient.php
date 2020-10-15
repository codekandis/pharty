<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

/**
 * Represents a registered client.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class RegisteredClient implements RegisteredClientInterface
{
	/**
	 * Stores the description of the client.
	 * @var string
	 */
	private string $description;

	/**
	 * Stores the ID of the client.
	 * @var string
	 */
	private string $id;

	/**
	 * Stores the passcode of the client.
	 * @var string
	 */
	private string $passCode;

	/**
	 * Stores the permission of the client.
	 * @var int
	 */
	private int $permission;

	/**
	 * Constructor method.
	 * @param string $description The description of the client.
	 * @param string $id The ID of the client.
	 * @param string $passCode The passcode of the client.
	 * @param int $permission The permission of the client.
	 */
	public function __construct( string $description, string $id, string $passCode, int $permission )
	{
		$this->description = $description;
		$this->id          = $id;
		$this->passCode    = $passCode;
		$this->permission  = $permission;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @inheritDoc
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @inheritDoc
	 */
	public function getPassCode(): string
	{
		return $this->passCode;
	}

	/**
	 * @inheritDoc
	 */
	public function getPermission(): int
	{
		return $this->permission;
	}
}
