<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

/**
 * Represents an enumeration of permissions.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class Permission
{
	/**
	 * Defines the permission as 'denied'.
	 * @var int
	 */
	public const DENIED = 0;

	/**
	 * Defines the permission as 'granted'.
	 * @var int
	 */
	public const GRANTED = 1;
}
