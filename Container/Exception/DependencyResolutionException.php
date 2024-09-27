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
use RuntimeException;

/**
 * Dependency relosution exception class.
 * 
 * Exception class for handling errors that occur during dependency resolution.
 * 
 * The `DependencyResolutionException` throws when the container fails to instantiate a 
 * dependency due to missing parameters, circular dependencies, or other resolution issues.
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
class DependencyResolutionException extends RuntimeException implements ContainerExceptionInterface
{
}
