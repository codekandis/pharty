<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

use CodeKandis\Pharty\Client\SessionHandler;
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
	private const ERROR_SESSION_KEY_DOES_NOT_EXIST = 'The session key \'%s\' does not exist in the session.';

	/**
	 * Stores the session key storing if the client has been authenticated.
	 * @var string
	 */
	private string $sessionKey;

	/**
	 * Stores the registered clients.
	 * @var RegisteredClientInterface[]
	 */
	private array $registeredClients;

	/**
	 * Stores the session handler of the session authenticator.
	 * @var SessionHandlerInterface
	 */
	private SessionHandlerInterface $sessionHandler;

	/**
	 * Constructor method.
	 * @param string The session key storing if the client has been authenticated.
	 * @param RegisteredClientInterface[] The registered clients.
	 */
	public function __construct( string $sessionKey, array $registeredClients )
	{
		$this->sessionKey        = $sessionKey;
		$this->registeredClients = $registeredClients;
		$this->sessionHandler    = new SessionHandler();
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
	 */
	public function grantPermission( ClientCredentialsInterface $clientCredentials ): bool
	{
		if ( true === $this->isClientGranted() )
		{
			return true;
		}
		foreach ( $this->registeredClients as $registeredClientFetched )
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
	 * {@inheritdoc}
	 */
	public function revokePermission(): void
	{
		$this->sessionHandler->start();
		$this->sessionHandler->regenerateId( true );
		$this->sessionHandler->set( $this->sessionKey, Permission::DENIED );
		$this->sessionHandler->writeClose();
	}
}
