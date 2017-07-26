<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessor;
use CodeKandis\Pharty\Data\ArrayKeyNotFoundException;
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
	 * Constructor method.
	 * @param array $configuration The application environment configuration.
	 * @throws EnvironmentConfigurationException The configuration `applicationName` is missing.
	 * @throws EnvironmentConfigurationException The configuration type of `applicationName` is invalid.
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
	}

	/**
	 * {@inheritdoc}
	 */
	public function getApplicationName(): string
	{
		return $this->applicationName;
	}
}
