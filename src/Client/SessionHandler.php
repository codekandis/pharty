<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Client;

use CodeKandis\Pharty\Data\ArrayAccessor;
use CodeKandis\Pharty\Data\ArrayAccessorInterface;
use CodeKandis\Pharty\Data\ArrayKeyNotFoundException;
use function session_destroy;
use function session_name;
use function session_regenerate_id;
use function session_start;
use function session_status;
use function session_write_close;
use function sprintf;

/**
 * Represents a class handling sessions.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SessionHandler implements SessionHandlerInterface
{
	/**
	 * Represents the error message if the session cannot be started.
	 * @var string
	 */
	protected const ERROR_SESSION_CANNOT_BE_STARTED = 'The session cannot be started.';

	/**
	 * Represents the error message if the session cannot be destroyed.
	 * @var string
	 */
	protected const ERROR_SESSION_CANNOT_BE_DESTROYED = 'The session cannot be destroyed.';

	/**
	 * Represents the error message if the session has not been started.
	 * @var string
	 */
	protected const ERROR_SESSION_HAS_NOT_BEEN_STARTED = 'The session has not been started.';

	/**
	 * Represents the error message if the session has been started.
	 * @var string
	 */
	protected const ERROR_SESSION_HAS_BEEN_STARTED = 'The session has been started.';

	/**
	 * Represents the error message if the session ID has not been regenerated.
	 * @var string
	 */
	protected const ERROR_SESSION_ID_HAS_NOT_BEEN_REGENERATED = 'The session ID has not been regenerated.';

	/**
	 * Represents the error message if the session cannot be written and closed.
	 * @var string
	 */
	protected const ERROR_SESSION_CANNOT_BE_WRITTEN_AND_CLOSED = 'The session cannot be written and closed.';

	/**
	 * Represents the error message if a session key does not exist.
	 * @var string
	 */
	protected const ERROR_SESSION_KEY_DOES_NOT_EXIST = 'The session key \'%s\' does not exist.';

	/**
	 * Stores the configuration of the session.
	 * @var array
	 */
	private array $configuration;

	/**
	 * Stores the array accessor managing the session array.
	 * @var null|ArrayAccessorInterface
	 */
	private ?ArrayAccessorInterface $sessionAccessor = null;

	/**
	 * Constructor method.
	 * @param array $configuration The configuration of the session.
	 */
	public function __construct( array $configuration = [] )
	{
		$this->configuration = $configuration;
	}

	/**
	 * @inheritDoc
	 */
	public function getStatus(): int
	{
		return session_status();
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session cannot be started.
	 */
	public function start(): bool
	{
		$sessionStarted = session_start( $this->configuration );
		if ( false === $sessionStarted )
		{
			throw new SessionCannotBeStartedException( static::ERROR_SESSION_CANNOT_BE_STARTED );
		}

		$this->sessionAccessor = new ArrayAccessor( $_SESSION );

		return $sessionStarted;
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 * @throws SessionCannotBeDestroyedException The session cannot be destroyed.
	 */
	public function destroy(): bool
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		$this->sessionAccessor = null;
		$_SESSION              = [];

		if ( ini_get( 'session.use_cookies' ) )
		{
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params[ 'path' ],
				$params[ 'domain' ],
				$params[ 'secure' ],
				$params[ 'httponly' ]
			);
		}

		$sessionDestroyed = session_destroy();
		if ( false === $sessionDestroyed )
		{
			throw new SessionCannotBeDestroyedException( static::ERROR_SESSION_CANNOT_BE_DESTROYED );
		}

		return $sessionDestroyed;
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 * @throws SessionCannotBeWrittenAndClosedException The session cannot be written and closed.
	 */
	public function writeClose(): void
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		$sessionWrittenAndClosed = session_write_close();
		if ( false === $sessionWrittenAndClosed )
		{
			throw new SessionCannotBeWrittenAndClosedException( static::ERROR_SESSION_CANNOT_BE_WRITTEN_AND_CLOSED );
		}

		$this->sessionAccessor = null;
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 */
	public function regenerateId( bool $deleteOldSession = false ): bool
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		$sessionIdRegenerated = session_regenerate_id( $deleteOldSession );
		if ( null === $sessionIdRegenerated )
		{
			throw new SessionIdNotRegeneratedException( static::ERROR_SESSION_ID_HAS_NOT_BEEN_REGENERATED );
		}

		return $sessionIdRegenerated;
	}

	/**
	 * @inheritDoc
	 * @throws SessionStartedException The session has been started.
	 */
	public function getName(): string
	{
		if ( null !== $this->sessionAccessor )
		{
			throw new SessionStartedException( static::ERROR_SESSION_HAS_BEEN_STARTED );
		}

		return session_name();
	}

	/**
	 * @inheritDoc
	 * @throws SessionStartedException The session has been started.
	 */
	public function setName( string $name ): void
	{
		if ( null !== $this->sessionAccessor )
		{
			throw new SessionStartedException( static::ERROR_SESSION_HAS_BEEN_STARTED );
		}

		session_name( $name );
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 */
	public function has( string $key ): bool
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		return $this->sessionAccessor->has( $key );
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 * @throws SessionKeyNotFoundException The session key does not exist.
	 */
	public function get( string $key )
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		try
		{
			return $this->sessionAccessor->get( $key );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new SessionKeyNotFoundException(
				sprintf(
					static::ERROR_SESSION_KEY_DOES_NOT_EXIST,
					$key
				),
				0,
				$exception
			);
		}
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 * @throws SessionKeyNotFoundException The session key does not exist.
	 */
	public function getDefaulted( string $key, $value )
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		if ( false === $this->sessionAccessor->has( $key ) )
		{
			$this->sessionAccessor->set( $key, $value );
		}
		try
		{
			return $this->sessionAccessor->get( $key );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new SessionKeyNotFoundException(
				sprintf(
					static::ERROR_SESSION_KEY_DOES_NOT_EXIST,
					$key
				),
				0,
				$exception
			);
		}
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 */
	public function set( string $key, $value ): void
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		$this->sessionAccessor->set( $key, $value );
	}

	/**
	 * @inheritDoc
	 * @throws SessionNotStartedException The session has not been started.
	 * @throws SessionKeyNotFoundException The session key does not exist.
	 */
	public function unset( string $key ): void
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		try
		{
			$this->sessionAccessor->unset( $key );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new SessionKeyNotFoundException(
				sprintf(
					static::ERROR_SESSION_KEY_DOES_NOT_EXIST,
					$key
				),
				0,
				$exception
			);
		}
	}
}
