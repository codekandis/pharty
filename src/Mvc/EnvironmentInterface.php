<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Http\HttpDataInterface;
use CodeKandis\Pharty\Security\AuthenticatorInterface;

/**
 * Represents the interface of all application environment classes.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
interface EnvironmentInterface
{
	/**
	 * Gets the name of the application.
	 * @return string The name of the application.
	 */
	public function getApplicationName(): string;

	/**
	 * Gets the HTTP data of the request.
	 * @return HttpDataInterface The HTTP data of the request.
	 */
	public function getHttpData(): HttpDataInterface;

	/**
	 * Gets the authenticator of the application.
	 * @return AuthenticatorInterface The authenticator of the application.
	 */
	public function getAuthenticator(): AuthenticatorInterface;

	/**
	 * Gets the pre-execution controllers of the application.
	 * @return ControllerInterface[] The pre-execution controllers of the application.
	 */
	public function getPreExecutionControllers(): array;

	/**
	 * Gets the post-execution controllers of the application.
	 * @return ControllerInterface[] The post-execution controllers of the application.
	 */
	public function getPostExecutionControllers(): array;
}
