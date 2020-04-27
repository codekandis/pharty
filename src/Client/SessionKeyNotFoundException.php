<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Client;

use CodeKandis\Pharty\Base\LogicException;

/**
 * Represents an exception if a session key does not exist.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SessionKeyNotFoundException extends LogicException
{
}
