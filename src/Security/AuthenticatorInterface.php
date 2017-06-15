<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

/**
 * Represents the interface of all authenticators.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface AuthenticatorInterface
{
	/**
	 * Determines if the client has been granted permission.
	 * @return bool True if the client has been granted permission, false otherwise.
	 * @throws AuthenticationIsCorruptedException The authentication data is corrupted.
	 */
	public function isClientGranted(): bool;

	/**
	 * Requests to grant the clients permission.
	 * @param ClientCredentialsInterface $clientCredentials The ID of the client.
	 * @return bool True if the client has been granted permission, false otherwise.
	 * @throws AuthenticationIsCorruptedException The authentication data is corrupted.
	 */
	public function grantPermission( ClientCredentialsInterface $clientCredentials ): bool;

	/**
	 * Revokes the permission of the client.
	 */
	public function revokePermission(): void;
}
