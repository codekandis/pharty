<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessor;
use CodeKandis\Pharty\Data\ArrayKeyNotFoundException;
use CodeKandis\Pharty\Http\HttpData;
use CodeKandis\Pharty\Http\HttpDataInterface;
use CodeKandis\Pharty\Security\AuthenticatorInterface;
use function is_array;
use function is_string;
use function sprintf;

/**
 * Represents the base class of all application environments.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class EnvironmentAbstract implements EnvironmentInterface
{
	/**
	 * Represents the error message if a configuration is missing.
	 * @var string
	 */
	private const ERROR_MISSING_CONFIGURATION = 'Missing configuration \'%s\'.';

	/**
	 * Represents the error message if a configuration type is invalid.
	 * @var string
	 */
	private const ERROR_INVALID_CONFIGURATION_TYPE = 'Invalid configuration type in \'%s\': \'%s\' expected.';

	/**
	 * Stores the name of the application.
	 * @var string
	 */
	private string $applicationName;

	/**
	 * Stores the HTTP data of the request.
	 * @var HttpDataInterface
	 */
	private HttpDataInterface $httpData;

	/**
	 * Stores the authenticator of the application.
	 * @var AuthenticatorInterface
	 */
	private AuthenticatorInterface $authenticator;

	/**
	 * Stores the pre-execution controllers of the application.
	 * @var ControllerInterface[]
	 */
	private array $preExecutionControllers;

	/**
	 * Stores the post-execution controllers of the application.
	 * @var ControllerInterface[]
	 */
	private array $postExecutionControllers;

	/**
	 * Stores the router of the application.
	 * @var RouterInterface
	 */
	private RouterInterface $router;

	/**
	 * {@inheritdoc}
	 */
	public function getPreExecutionControllers(): array
	{
		return $this->preExecutionControllers;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPostExecutionControllers(): array
	{
		return $this->postExecutionControllers;
	}

	/**
	 * Constructor method.
	 * @param array $configuration The application environment configuration.
	 * @throws EnvironmentConfigurationException The configuration `applicationName` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `applicationName` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing` is invalid.
	 */
	public function __construct( array $configuration )
	{
		$configurationAccessor = new ArrayAccessor( $configuration );
		try
		{
			$applicationName = $configurationAccessor->get( 'applicationName' );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_MISSING_CONFIGURATION,
					'applicationName'
				),
				0,
				$exception
			);
		}
		if ( false === is_string( $applicationName ) )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_INVALID_CONFIGURATION_TYPE,
					'applicationName',
					'string'
				)
			);
		}
		$this->applicationName = $applicationName;
		try
		{
			$routingConfiguration = $configurationAccessor->get( 'routing' );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_MISSING_CONFIGURATION,
					'routing'
				),
				0,
				$exception
			);
		}
		if ( false === is_array( $routingConfiguration ) )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_INVALID_CONFIGURATION_TYPE,
					'routing',
					'array'
				)
			);
		}
		$this->initializePreExecutionControllers( $routingConfiguration );
		$this->initializePostExecutionControllers( $routingConfiguration );
		$this->initializeRouter( $routingConfiguration );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getApplicationName(): string
	{
		return $this->applicationName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHttpData(): HttpDataInterface
	{
		return $this->httpData ?? $this->httpData = new HttpData();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthenticator(): AuthenticatorInterface
	{
		return $this->authenticator;
	}

	/**
	 * Sets the authenticator of the application.
	 * @param AuthenticatorInterface $authenticator The authenticator of the application.
	 */
	protected function setAuthenticator( AuthenticatorInterface $authenticator ): void
	{
		$this->authenticator = $authenticator;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRouter(): RouterInterface
	{
		return $this->router;
	}

	/**
	 * Sets the router of the application.
	 * @param RouterInterface $router The router of the application.
	 */
	protected function setRouter( RouterInterface $router ): void
	{
		$this->router = $router;
	}

	/**
	 * Initializes the pre-execution controllers of the application.
	 * @param array $routingConfiguration The routing configuration of the application.
	 * @throws EnvironmentConfigurationException The configuration `routing[ preExecutionControllers ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ preExecutionControllers ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ preExecutionControllers ][ ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ preExecutionControllers ][ ][ class ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ preExecutionControllers ][ ][ class ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ preExecutionControllers ][ ][ data ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ preExecutionControllers ][ ][ data ]` is invalid.
	 */
	private function initializePreExecutionControllers( array $routingConfiguration ): void
	{
		try
		{
			$controllersConfiguration = ( new ArrayAccessor( $routingConfiguration ) )
				->get( 'preExecutionControllers' );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_MISSING_CONFIGURATION,
					'routing[ preExecutionControllers ]'
				),
				0,
				$exception
			);
		}
		if ( false === is_array( $controllersConfiguration ) )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_INVALID_CONFIGURATION_TYPE,
					'routing[ preExecutionControllers ]',
					'array'
				)
			);
		}
		$this->preExecutionControllers = [];
		/* @var array $controllersConfiguration */
		foreach ( $controllersConfiguration as $controllerConfigurationFetched )
		{
			if ( false === is_array( $controllerConfigurationFetched ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ preExecutionControllers ][ ]',
						'array'
					)
				);
			}
			$controllerConfigurationAccessor = new ArrayAccessor( $controllerConfigurationFetched );
			try
			{
				$controllerClass = $controllerConfigurationAccessor->get( 'class' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ preExecutionControllers ][ ][ class ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_string( $controllerClass ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ preExecutionControllers ][ ][ class ]',
						'string'
					)
				);
			}
			try
			{
				$controllerData = $controllerConfigurationAccessor->get( 'data' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ preExecutionControllers ][ ][ data ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_array( $controllerData ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ preExecutionControllers ][ ][ data ]',
						'array'
					)
				);
			}
			$this->preExecutionControllers[] = new $controllerClass(
				$this,
				new ArrayAccessor( $controllerData )
			);
		}
	}

	/**
	 * Initializes the pre-execution controllers of the application.
	 * @param array $routingConfiguration The routing configuration of the application.
	 * @throws EnvironmentConfigurationException The configuration `routing[ postExecutionControllers ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ postExecutionControllers ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ postExecutionControllers ][ ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ postExecutionControllers ][ ][ class ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ postExecutionControllers ][ ][ class ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ postExecutionControllers ][ ][ data ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ postExecutionControllers ][ ][ data ]` is invalid.
	 */
	private function initializePostExecutionControllers( array $routingConfiguration ): void
	{
		try
		{
			$controllersConfiguration = ( new ArrayAccessor( $routingConfiguration ) )
				->get( 'postExecutionControllers' );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_MISSING_CONFIGURATION,
					'routing[ postExecutionControllers ]'
				),
				0,
				$exception
			);
		}
		if ( false === is_array( $controllersConfiguration ) )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_INVALID_CONFIGURATION_TYPE,
					'routing[ postExecutionControllers ]',
					'array'
				)
			);
		}
		$this->postExecutionControllers = [];
		/* @var array $controllersConfiguration */
		foreach ( $controllersConfiguration as $controllerConfigurationFetched )
		{
			if ( false === is_array( $controllerConfigurationFetched ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ postExecutionControllers ][ ]',
						'array'
					)
				);
			}
			$controllerConfigurationAccessor = new ArrayAccessor( $controllerConfigurationFetched );
			try
			{
				$controllerClass = $controllerConfigurationAccessor->get( 'class' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ postExecutionControllers ][ ][ class ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_string( $controllerClass ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ postExecutionControllers ][ ][ class ]',
						'string'
					)
				);
			}
			try
			{
				$controllerData = $controllerConfigurationAccessor->get( 'data' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ postExecutionControllers ][ ][ data ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_array( $controllerData ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ postExecutionControllers ][ ][ data ]',
						'array'
					)
				);
			}
			$this->postExecutionControllers[] = new $controllerClass(
				$this,
				new ArrayAccessor( $controllerData )
			);
		}
	}

	/**
	 * Initializes the router.
	 * @param array $routingConfiguration The routing configuration.
	 * @throws EnvironmentConfigurationException The configuration `routing[ routes ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ routes ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ routes ][ ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ routes ][ ][ pattern ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ routes ][ ][ pattern ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ routes ][ ][ class ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ routes ][ ][ class ]` is invalid.
	 * @throws EnvironmentConfigurationException The configuration `routing[ routes ][ ][ data ]` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `routing[ routes ][ ][ data ]` is invalid.
	 */
	private function initializeRouter( array $routingConfiguration ): void
	{
		try
		{
			$routesConfiguration = ( new ArrayAccessor( $routingConfiguration ) )
				->get( 'routes' );
		}
		catch ( ArrayKeyNotFoundException $exception )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_MISSING_CONFIGURATION,
					'routing[ routes ]'
				),
				0,
				$exception
			);
		}
		if ( false === is_array( $routesConfiguration ) )
		{
			throw new EnvironmentConfigurationException(
				sprintf(
					static::ERROR_INVALID_CONFIGURATION_TYPE,
					'routing[ routes ]',
					'array'
				)
			);
		}
		$routes = [];
		/* @var array $routesConfiguration */
		foreach ( $routesConfiguration as $routeConfigurationFetched )
		{
			if ( false === is_array( $routeConfigurationFetched ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ routes ][ ]',
						'array'
					)
				);
			}
			$routeConfigurationAccessor = new ArrayAccessor( $routeConfigurationFetched );
			try
			{
				$pattern = $routeConfigurationAccessor->get( 'pattern' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ routes ][ ][ pattern ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_string( $pattern ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ routes ][ ][ pattern ]',
						'string'
					)
				);
			}
			try
			{
				$controllerHttpMethod = $routeConfigurationAccessor->get( 'httpMethod' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ routes ][ ][ httpMethod ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_string( $controllerHttpMethod ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ routes ][ ][ httpMethod ]',
						'string'
					)
				);
			}
			try
			{
				$controllerClass = $routeConfigurationAccessor->get( 'class' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ routes ][ ][ class ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_string( $controllerClass ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ routes ][ ][ class ]',
						'string'
					)
				);
			}
			try
			{
				$controllerData = $routeConfigurationAccessor->get( 'data' );
			}
			catch ( ArrayKeyNotFoundException $exception )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_MISSING_CONFIGURATION,
						'routing[ routes ][ ][ data ]'
					),
					0,
					$exception
				);
			}
			if ( false === is_array( $controllerData ) )
			{
				throw new EnvironmentConfigurationException(
					sprintf(
						static::ERROR_INVALID_CONFIGURATION_TYPE,
						'routing[ routes ][ ][ data ]',
						'array'
					)
				);
			}
			$routes[] = new Route( $pattern, $controllerHttpMethod, $controllerClass, $controllerData );
		}
		$this->setRouter( new Router( $routes ) );
	}
}
