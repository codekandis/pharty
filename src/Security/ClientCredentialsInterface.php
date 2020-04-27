<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

/**
 * Represents the interface of all client credentials.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ClientCredentialsInterface
{
	/**
	 * Gets the ID of the client.
	 * @return string The ID of the client.
	 */
	public function getId(): string;

	/**
	 * Gets the MD5 hash of the ID of the client.
	 * @return string The MD5 hash of the ID of the client.
	 */
	public function getIdMd5(): string;

	/**
	 * Gets the passcode of the client.
	 * @return string The passcode of the client.
	 */
	public function getPassCode(): string;

	/**
	 * Gets the MD5 hash of the passcode of the client.
	 * @return string The MD5 hash of the passcode of the client.
	 */
	public function getPassCodeMd5(): string;
}
