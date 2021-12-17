<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Http\HttpMethod;
use function strtok;

/**
 * Represents the base class of all applications.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class ApplicationAbstract implements ApplicationInterface
{
	/**
	 * Stores the application environment.
	 * @var EnvironmentInterface
	 */
	private EnvironmentInterface $environment;

	/**
	 * Constructor method.
	 * @param EnvironmentInterface $environment The application environment.
	 */
	public function __construct( EnvironmentInterface $environment )
	{
		$this->environment = $environment;
	}

	/**
	 * Gets the application environment of the application.
	 * @return EnvironmentInterface The application environment of the application.
	 */
	protected function getEnvironment(): EnvironmentInterface
	{
		return $this->environment;
	}

	/**
	 * @inheritDoc
	 */
	public function getName(): string
	{
		return $this->environment->getApplicationName();
	}

	/**
	 * Executes all pre-execution controllers.
	 * @return bool True if the routing can be continued, otherwise false.
	 */
	private function executePreExecutionControllers(): bool
	{
		foreach ( $this->getEnvironment()->getPreExecutionControllers() as $preExecutionControllerFetched )
		{
			if ( false === $preExecutionControllerFetched->execute() )
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Executes all post-execution controllers.
	 */
	private function executePostExecutionControllers(): void
	{
		foreach ( $this->getEnvironment()->getPostExecutionControllers() as $postExecutionControllerFetched )
		{
			if ( false === $postExecutionControllerFetched->execute() )
			{
				return;
			}
		}
	}

	/**
	 * Executes a routed controller.
	 */
	private function executeRoutedController(): void
	{
		$requestMethod = $this->getEnvironment()->getHttpData()->getServer()->getDefaulted( 'REQUEST_METHOD', HttpMethod::GET );
		$requestUri    = strtok( $this->getEnvironment()->getHttpData()->getServer()->getDefaulted( 'REQUEST_URI', '/' ), '?' );
		/**
		 * @var ResolvedRouteInterface $resolvedRoute
		 */
		$resolvedRoute   = $this->getEnvironment()->getRouter()->resolveRoute( $requestMethod, $requestUri );
		$controllerClass = $resolvedRoute->getRoute()->getClass();
		/**
		 * @var ControllerInterface $controller
		 */
		$controller = new $controllerClass( $this->getEnvironment(), $resolvedRoute->getData() );
		$controller->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function execute(): void
	{
		$postExecutionControllersResult = $this->executePreExecutionControllers();
		if ( true === $postExecutionControllersResult )
		{
			$this->executeRoutedController();
		}
		$this->executePostExecutionControllers();
	}
}
