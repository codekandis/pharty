<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Mvc;

use CodeKandis\Pharty\Data\ArrayAccessorInterface;

/**
 * Represents the base class of all controllers.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class ControllerAbstract implements ControllerInterface
{
	/**
	 * Stores the application environment.
	 * @var EnvironmentInterface
	 */
	private EnvironmentInterface $environment;

	/**
	 * Stores the data of the controller.
	 * @var ArrayAccessorInterface
	 */
	private ArrayAccessorInterface $data;

	/**
	 * Constructor method.
	 * @param EnvironmentInterface $environment The application environment.
	 * @param ArrayAccessorInterface $data The data of the controller.
	 */
	public function __construct( EnvironmentInterface $environment, ArrayAccessorInterface $data )
	{
		$this->environment = $environment;
		$this->data        = $data;
	}

	/**
	 * Gets the application environment.
	 * @return EnvironmentInterface The application environment.
	 */
	protected function getEnvironment(): EnvironmentInterface
	{
		return $this->environment;
	}

	/**
	 * Gets the data of the controller.
	 * @return ArrayAccessorInterface The data of the controller.
	 */
	protected function getData(): ArrayAccessorInterface
	{
		return $this->data;
	}
}
