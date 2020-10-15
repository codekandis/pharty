<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

use CodeKandis\Pharty\Client\SessionHandlerInterface;
use CodeKandis\Pharty\Data\ArrayKeyNotFoundException;
use function sprintf;

/**
 * Represents an authenticator based on a session.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SessionAuthenticator implements AuthenticatorInterface
{
	/**
	 * Represents the error message if a session key does not exist.
	 * @var string
	 */
	protected const ERROR_SESSION_KEY_DOES_NOT_EXIST = 'The session key \'%s\' does not exist in the session.';

	/**
	 * Stores the session handler of the session authenticator.
	 * @var SessionHandlerInterface
	 */
	private SessionHandlerInterface $sessionHandler;

	/**
	 * Stores the session key storing if the client has been authenticated.
	 * @var string
	 */
	private string $sessionKey;

	/**
	 * Constructor method.
	 * @param SessionHandlerInterface $sessionHandler The session handler the authentication adapter is based on.
	 * @param string The session key storing if the client has been authenticated.
	 */
	public function __construct( SessionHandlerInterface $sessionHandler, string $sessionKey )
	{
		$this->sessionHandler = $sessionHandler;
		$this->sessionKey     = $sessionKey;
		$this->initAuthentication();
	}

	/**
	 * Initializes the authentication.
	 */
	private function initAuthentication(): void
	{
		$this->sessionHandler->start();
		if ( false === $this->sessionHandler->has( $this->sessionKey ) )
		{
			$this->sessionHandler->regenerateId( true );
			$this->sessionHandler->set( $this->sessionKey, Permission::DENIED );
		}
		$this->sessionHandler->writeClose();
	}

	/**
	 * @inheritDoc
	 */
	public function isClientGranted(): bool
	{
		$this->sessionHandler->start();
		try
		{
			$permission = $this->sessionHandler->get( $this->sessionKey );
			$this->sessionHandler->writeClose();
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			$this->sessionHandler->destroy();
			throw new AuthenticationIsCorruptedException(
				sprintf(
					static::ERROR_SESSION_KEY_DOES_NOT_EXIST,
					$this->sessionKey
				),
				0,
				$exception
			);
		}

		return $permission === Permission::GRANTED;
	}

	/**
	 * @inheritDoc
	 */
	public function grantPermission( array $registeredClients, ClientCredentialsInterface $clientCredentials ): bool
	{
		if ( true === $this->isClientGranted() )
		{
			return true;
		}
		foreach ( $registeredClients as $registeredClientFetched )
		{
			$registeredClientPermission   = $registeredClientFetched->getPermission();
			$registeredClientId           = $registeredClientFetched->getId();
			$registeredClientPassCode     = $registeredClientFetched->getPassCode();
			$clientCredentialsIdMd5       = $clientCredentials->getIdMd5();
			$clientCredentialsPassCodeMd5 = $clientCredentials->getPassCodeMd5();
			if (
				$registeredClientPermission === Permission::GRANTED
				&& $registeredClientId === $clientCredentialsIdMd5
				&& $registeredClientPassCode === $clientCredentialsPassCodeMd5
			)
			{
				$this->sessionHandler->start();
				$this->sessionHandler->regenerateId( true );
				$this->sessionHandler->set( $this->sessionKey, Permission::GRANTED );
				$this->sessionHandler->writeClose();

				return true;
			}
		}

		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function revokePermission(): void
	{
		$this->sessionHandler->start();
		$this->sessionHandler->regenerateId( true );
		$this->sessionHandler->set( $this->sessionKey, Permission::DENIED );
		$this->sessionHandler->writeClose();
	}
}
