<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

use function md5;

/**
 * Represents client credentials.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class ClientCredentials implements ClientCredentialsInterface
{
	/**
	 * Stores the ID of the client.
	 * @var string
	 */
	private string $id;

	/**
	 * Stores the MD5 hash of the ID of the client.
	 * @var string
	 */
	private string $idMd5;

	/**
	 * Stores the passcode of the client.
	 * @var string
	 */
	private string $passCode;

	/**
	 * Stores the MD5 hash of the passcode of the client.
	 * @var string
	 */
	private string $passCodeMd5;

	/**
	 * Constructor method.
	 * @param string $id The ID of the client.
	 * @param string $passCode The passcode of the client.
	 */
	public function __construct( string $id, string $passCode )
	{
		$this->id          = $id;
		$this->idMd5       = md5( $id );
		$this->passCode    = $passCode;
		$this->passCodeMd5 = md5( $passCode );
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
	public function getIdMd5(): string
	{
		return $this->idMd5 ?? $this->idMd5 = md5( $this->id );
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
	public function getPassCodeMd5(): string
	{
		return $this->passCodeMd5 ?? $this->passCodeMd5 = md5( $this->passCode );
	}
}
