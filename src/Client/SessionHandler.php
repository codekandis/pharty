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
use function session_unset;
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
	 * Represents the error message if the session has not been started.
	 * @var string
	 */
	protected const ERROR_SESSION_HAS_NOT_BEEN_STARTED = 'The session has not been started.';

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
	 * {@inheritdoc}
	 */
	public function getStatus(): int
	{
		return session_status();
	}

	/**
	 * {@inheritdoc}
	 */
	public function start(): bool
	{
		$sessionStarted = session_start( $this->configuration );
		if ( true === $sessionStarted )
		{
			$this->sessionAccessor = new ArrayAccessor( $_SESSION );
		}

		return $sessionStarted;
	}

	/**
	 * {@inheritdoc}
	 */
	public function destroy(): bool
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		session_unset();
		$this->sessionAccessor = null;

		return session_destroy();
	}

	/**
	 * {@inheritdoc}
	 */
	public function writeClose(): void
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		session_write_close();
	}

	/**
	 * {@inheritdoc}
	 */
	public function regenerateId( bool $deleteOldSession = false ): bool
	{
		if ( null === $this->sessionAccessor )
		{
			throw new SessionNotStartedException( static::ERROR_SESSION_HAS_NOT_BEEN_STARTED );
		}

		return session_regenerate_id( $deleteOldSession );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName(): string
	{
		return session_name();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setName( string $name ): void
	{
		session_name( $name );
	}

	/**
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
