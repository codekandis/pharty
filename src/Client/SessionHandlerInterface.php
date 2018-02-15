<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Client;

/**
 * Represents the interface of all session handler managing sessions.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface SessionHandlerInterface
{
	/**
	 * Gets the state of the current session.
	 * @return int SessionStatus::DISABLED if sessions are disabled, SessionStatus::NONE if sessions are enabled, but none exists, SessionStatus::ACTIVE if sessions are enabled and one exists.
	 */
	public function getStatus(): int;

	/**
	 * Start a new or resumes an existing session.
	 * @return bool True if the session has been started or resumed successfully, false otherwise.
	 */
	public function start(): bool;

	/**
	 * Destroys all data registered to a session.
	 * @return bool True if the registered data has been destroyed successfully, false otherwise.
	 */
	public function destroy(): bool;

	/**
	 * Writes and closes a session.
	 */
	public function writeClose(): void;

	/**
	 * Replaces the old session ID with a new one.
	 * @param bool $deleteOldSession [false] Specifies if the old session should be deleted.
	 * @return bool True if the session ID has been replaced successfully, false otherwise.
	 */
	public function regenerateId( bool $deleteOldSession = false ): bool;

	/**
	 * Gets the name of the session.
	 * @return string The name of the session.
	 */
	public function getName(): string;

	/**
	 * Sets the name of the session.
	 * @param string $name The name of the session.
	 */
	public function setName( string $name ): void;

	/**
	 * Determines if the session has a specific key value pair.
	 * @param string $key The key to determine if it exists.
	 * @return bool True if the session has the specific key value pair, false otherwise.
	 */
	public function has( string $key ): bool;

	/**
	 * Gets a value from the session.
	 * @param string $key The key to get its value from the session.
	 * @return mixed The value from the session.
	 * @throws SessionKeyNotFoundException The passed key does not exist.
	 */
	public function get( string $key );

	/**
	 * Gets a value from the session or a specific default value, if the
	 * key value pair does not exist. The default value will be set instead.
	 * @param string $key The key to get its value from the session.
	 * @param mixed $default The default value if the key value pair does not exist.
	 * @return mixed The value from the session.
	 * @throws SessionKeyNotFoundException The passed key does not exist.
	 */
	public function getDefaulted( string $key, $default );

	/**
	 * Sets a value of the session.
	 * @param string $key The key to set its value to the session.
	 * @param mixed $value The value to set to the session.
	 */
	public function set( string $key, $value ): void;

	/**
	 * Unsets a value from the session.
	 * @param string $key The key to unset its value from the session.
	 * @throws SessionKeyNotFoundException The passed key does not exist.
	 */
	public function unset( string $key ): void;
}
