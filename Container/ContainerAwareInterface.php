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
namespace Framework\Container;

/**
 * Container aware interface.
 * 
 * Interface for classes that are aware of a dependency injection container.
 * 
 * This interface defines a method for setting the dependency injection container,
 * allowing implementing classes to access services and resources managed by the container.
 * This is useful for achieving better decoupling and dependency management within an application.
 * 
 * @category    Framework
 * @package     Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
interface ContainerAwareInterface
{
    /**
     * Sets the dependency injection container.
     *
     * This method allows the class to receive the container instance,
     * enabling it to retrieve dependencies and services as needed.
     * 
     * @param  Container $container Holds the dependency injection container object.
     * @return mixed
     */
    public function setContainer( Container $container ) : mixed;
}