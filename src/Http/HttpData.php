<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Http;

use CodeKandis\Pharty\Data\ArrayAccessor;
use CodeKandis\Pharty\Data\ArrayAccessorInterface;

/**
 * Represents a HTTP data container.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class HttpData implements HttpDataInterface
{
	/**
	 * Stores the HTTP SERVER data.
	 * @var ArrayAccessorInterface
	 */
	private ArrayAccessorInterface $server;

	/**
	 * Stores the HTTP GET data.
	 * @var ArrayAccessorInterface
	 */
	private ArrayAccessorInterface $get;

	/**
	 * Stores the HTTP POST data.
	 * @var ArrayAccessorInterface
	 */
	private ArrayAccessorInterface $post;

	/**
	 * @inheritDoc
	 */
	public function getServer(): ArrayAccessorInterface
	{
		return $this->server ?? $this->server = new ArrayAccessor( $_SERVER );
	}

	/**
	 * @inheritDoc
	 */
	public function getGet(): ArrayAccessorInterface
	{
		return $this->get ?? $this->get = new ArrayAccessor( $_GET );
	}

	/**
	 * @inheritDoc
	 */
	public function getPost(): ArrayAccessorInterface
	{
		return $this->post ?? $this->post = new ArrayAccessor( $_POST );
	}
}
