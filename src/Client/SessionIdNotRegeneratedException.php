<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Client;

use CodeKandis\Pharty\Base\LogicException;

/**
 * Represents an exception if a session ID has not been regenerated.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class SessionIdNotRegeneratedException extends LogicException
{
}
