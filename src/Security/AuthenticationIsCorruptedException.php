<?php declare( strict_types = 1 );
namespace CodeKandis\Pharty\Security;

use CodeKandis\Pharty\Base\RuntimeException;

/**
 * Represents the exception if the authentication is corrupted.
 * @package codekandis/pharty
 * @author Christian Ramelow <info@codekandis.net>
 */
class AuthenticationIsCorruptedException extends RuntimeException
{
}
