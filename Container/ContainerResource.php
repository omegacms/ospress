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
use function is_callable;
use function is_object;

/**
 * Service provider interface.
 * 
 * A service provider is responsible for registering services and their dependencies
 * with a dependency injection container. Implementing classes will define
 * how services are configured and made available within the application.
 * 
 * @category    Framework
 * @package     Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
final class ContainerResource
{
    /**
     * Defines the resource as non-shared.
     * 
     * This constant indicates that the resource should not be shared across multiple
     * instances or consumers, ensuring that each consumer has its own separate instance.
     * 
     * @const integer NO_SHARE Value representing a non-shared resource.
     */
    public const NO_SHARE = 0;

    /**
     * Defines the resource as shared.
     * 
     * This constant indicates that the resource can be shared across multiple instances
     * or consumers, allowing for shared access to a single instance.
     *
     * @const integer SHARE Value representing a shared resource.
     */
    public const SHARE = 1;

    /**
     * Defines the resource as non-protected.
     * 
     * This constant indicates that the resource does not have any protection
     * applied to it, allowing for unrestricted access and modifications.
     *
     * @const integer NO_PROTECT Value representing a non-protected resource.
     */
    public const NO_PROTECT = 0;

    /**
     * Defines the resource as protected.
     * 
     * This constant indicates that the resource has protection applied,
     * restricting access and modifications to authorized instances or consumers only.
     *
     * @const integer PROTECT Value representing a protected resource.
     */
    public const PROTECT = 2;

    /**
     * The object instance for a shared object
     *
     * @var mixed $instance Holds the object instance for a shared object.
     */
    private mixed $instance;

    /**
     * The factory object
     *
     * @var callable $factory Holds the callable factory object.
     */
    private mixed $factory;

    /**
     * Flag if the resource is shared
     *
     * @var bool $shard False if hte resource is shared, true if not.
     */
    private bool $shared = false;

    /**
     * Flag if the resource is protected
     *
     * @var bool $protected False if the resource is protected, true if not.
     */
    private bool $protected = false;

    /**
     * Create a resource representation.
     *
     * This constructor initializes a resource instance based on the provided value and mode.
     * The resource can be either a direct value or a factory closure that produces the resource.
     * The mode determines the sharing and protection status of the resource.
     *
     * @param  Container $container Holds the current dependency injection container object.
     * @param  mixed     $value     Holds the resource or its factory closure
     * @param  int       $mode      The resource mode, defaults to Resource::NO_SHARE | Resource::NO_PROTECT
     * @return void
     */
    public function __construct( private Container $container, mixed $value, int $mode = 0 )
    {
        $this->container = $container;
        $this->shared    = ( $mode & self::SHARE   ) === self::SHARE;
        $this->protected = ( $mode & self::PROTECT ) === self::PROTECT;

        if ( is_callable( $value ) ) {
            $this->factory = $value;
        } else {
            if ( $this->shared ) {
                $this->instance = $value;
            }

            if ( is_object( $value ) ) {
                $this->factory = function () use ( $value ) {
                    return clone $value;
                };
            } else {
                $this->factory = function () use ( $value ) {
                    return $value;
                };
            }
        }
    }

    /**
     * Check whether the resource is shared.
     *
     * This method returns true if the resource is configured to be shared across
     * multiple instances, meaning that the same instance will be returned on subsequent calls.
     *
     * @return bool Return true if the resource is shared.
     */
    public function isShared() : bool
    {
        return $this->shared;
    }

    /**
     * Check whether the resource is protected.
     *
     * This method returns true if the resource is configured as protected,
     * which restricts its access and modification to authorized instances only.
     *
     * @return bool Return true if the resource is protected.
     */
    public function isProtected() : bool
    {
        return $this->protected;
    }

    /**
     * Get an instance of the resource.
     *
     * This method retrieves an instance of the resource. If a factory was provided,
     * it will create the resource, caching the instance if it is shared. If the resource
     * was provided directly, that resource will be returned as-is.
     *
     * @return mixed
     */
    public function getInstance() : mixed
    {
        $callable = $this->factory;

        if ( $this->isShared() ) {
            if ( $this->instance === null ) {
                $this->instance = $callable( $this->container );
            }

            return $this->instance;
        }

        return $callable( $this->container );
    }

    /**
     * Get the factory.
     *
     * This method returns the callable factory used to create the resource.
     *
     *
     * @return callable Return the callable factory.
     */
    public function getFactory() : callable
    {
        return $this->factory;
    }

    /**
     * Reset the resource.
     *
     * This method clears the cached instance of the resource, allowing a new instance
     * to be created on the next call to getInstance(). This reset applies only to shared,
     * non-protected resources.
     *
     * @return bool Return true if the resource was reset, false otherwise.
     */
    public function reset() : bool
    {
        if ( $this->isShared() && ! $this->isProtected() ) {
            $this->instance = null;

            return true;
        }

        return false;
    }
}