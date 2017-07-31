<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

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
	 * {@inheritdoc}
	 */
	public function getName(): string
	{
		return $this->environment->getApplicationName();
	}

	/**
	 * Executes all pre-execution controllers.
	 * @return bool True if the routed controller can be executed, false otherwise.
	 */
	private function executePreExecutionControllers(): bool
	{
		$result = true;
		foreach ( $this->getEnvironment()->getPreExecutionControllers() as $preExecutionControllerFetched )
		{
			$result = $result && $preExecutionControllerFetched->execute();
		}

		return $result;
	}

	/**
	 * Executes all post-execution controllers.
	 */
	private function executePostExecutionControllers(): void
	{
		foreach ( $this->getEnvironment()->getPostExecutionControllers() as $postExecutionControllerFetched )
		{
			$postExecutionControllerFetched->execute();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute(): void
	{
		$result = $this->executePreExecutionControllers();
		$this->executePostExecutionControllers();
	}
}
