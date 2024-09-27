<?php
/**
 * Part of Omega CMS - Container Package
 *
 * @link       https://omegacms.github.io
 * @author     Adriano Giovannini <omegacms@outlook.com>
 * @copyright  Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */
/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Framework\Container\Exception;

/**
 * @use
 */
use OutOfBoundsException;

/**
 * Protected key exception class.
 * 
 * Exception thrown when there is an attempt to set the value of a protected key that is already set.
 * 
 * The `ProtectedKeyException` is used to enforce the immutability of specific keys in the container,
 * preventing accidental overwrites of critical configuration or services.
 * 
 * @category    Framework
 * @package     Container
 * @subpackage  Exception
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ProtectedKeyException extends OutOfBoundsException implements ContainerExceptionInterface
{
}
