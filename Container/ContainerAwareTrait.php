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
 * @use
 */
use function get_class;
use Framework\Container\Exception\ContainerNotFoundException;

/**
 * Container aware trait.
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
trait ContainerAwareTrait
{
    /**
     * Dependency injection object.
     * 
     * This property holds the current instance of the dependency injection container,
     * allowing access to services and resources managed by the container.
     *
     * @var Container $container Holds the current dependency injection object.
     */
    private Container $container;

    /**
     * Retrieves the dependency injection container.
     * 
     * This method returns the current instance of the dependency injection container.
     * If the container has not been set, it throws a ContainerNotFoundException.
     * 
     * @return Container The current object of the dependency injection container.
     * @throws ContainerNotFoundException If the container has not been set.
     */
    public function getContainer() : Container
    {
        if ( $this->container ) {
            return $this->container;
        }

        throw new ContainerNotFoundException(
            'Container is not set in '
            . get_class()
        );
    }

    /**
     * Sets the dependency injection container.
     *
     * This method allows the class to receive the container instance,
     * enabling it to retrieve dependencies and services as needed.
     * 
     * @param  Container $container The dependency injection container object.
     * @return mixed
     */
    public function setContainer( Container $container ) : mixed
    {
        $this->container = $container;

        return $this;
    }
}