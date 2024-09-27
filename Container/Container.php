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
use function array_merge;
use function array_keys;
use function array_pop;
use function array_unique;
use function call_user_func;
use function class_exists;
use function in_array;
use function interface_exists;
use function sprintf;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionUnionType;
use Framework\Container\Exception\DependencyResolutionException;
use Framework\Container\Exception\KeyNotFoundException;
use Framework\Container\Exception\ProtectedKeyException;

/**
 * The container class.
 * 
 * @category    Framework
 * @package     Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Container implements ContainerInterface
{
    /**
     * Holds the key aliases.
     *
     * Array formar:
     * ```php
     * 'alias' => 'key'
     * ```
     * 
     * @var array<string, string> $aliases Holds the key aliases.
     */
    protected array $aliases = [];

    /**
     * Holds the resources.
     *
     * @var ContainerResource[] $resources Holds an array of ContainerResource.
     */
    protected array $resources = [];

    /**
     * Holds the service tag mapping.
     *
     * @var array<string, array<string>> $tags Holds an array of services tag.
     */
    protected array $tags = [];

    /**
     * Constructor for the DI Container.
     *
     * @param  Container|ContainerInterface|null  $parent  Parent for hierarchical containers.
     *
     * @since   1.0
     */
    public function __construct( protected Container|ContainerInterface|null $parent = null )
    {
        $this->parent = $parent;
    }

    /**
     * Retrieve a resource.
     *
     * @param  string $id Holds the name of the resource to get.
     * @return mixed  Return the requested resource.
     * @throws KeyNotFoundException if the resource is not register with the container.
     */
    public function get( string $id ) : mixed
    {
        $key = $this->resolveAlias( $id );

        if ( ! isset( $this->resources[ $key ] ) ) {
            if ( $this->parent instanceof ContainerInterface && $this->parent->has( $key ) ) {
                return $this->parent->get( $key );
            }

            throw new KeyNotFoundException(
                sprintf(
                    "Resource '%s' has not been registered with the container.", 
                    $id
                )
            );
        }

        return $this->resources[ $key ]->getInstance();
    }

    /**
     * Check if specified resource exists.
     *
     * @param  string  $id Holds the name of the resource to check.
     * @return bool Return true if key is defined, false otherwise.
     */
    public function has( string $id ) : bool
    {
        $key = $this->resolveAlias( $id );

        if ( ! isset( $this->resources[ $key ] ) ) {
            if ( $this->parent instanceof ContainerInterface ) {
                return $this->parent->has( $key );
            }

            return false;
        }

        return true;
    }

    /**
     * Create an alias for a given key for easy access.
     *
     * @param  string $alias Holds the alias name.
     * @param  string $key   Holds the key to alias.
     * @return static
     */
    public function alias( string $alias, string $key ) : static
    {
        $this->aliases[ $alias ] = $key;

        return $this;
    }

    /**
     * Resolve a resource name.
     *
     * If the resource name is an alias, the corresponding key is returned.
     * If the resource name is not an alias, the resource name is returned unchanged.
     *
     * @param  string $id Holds the key to search for.
     * @return string Return the resolved resource name.
     */
    protected function resolveAlias( string $id ) : string
    {
        return $this->aliases[ $id ] ?? $id;
    }

    /**
     * Check whether a resource is shared
     *
     * @param  string $id Holds the name of the resource to check.
     * @return bool Return true if the resource is shared, false if not.
     */
    public function isShared( string $id ) : bool
    {
        return $this->hasFlag( $id, 'isShared', true );
    }

    /**
     * Check whether a resource is protected
     *
     * @param  string $id Holds the name of the resource to check.
     * @return bool Return true if the resource is protected, false if not.
     */
    public function isProtected( string $id ) : bool
    {
        return $this->hasFlag( $id, 'isProtected', true );
    }

    /**
     * Check whether a resource is stored locally
     *
     * @param  string $id Holds the name of the resource to check.
     * @return bool Return true if the resource is stored locally, false if not.
     */
    private function isLocal( string $id ) : bool
    {
        $key = $this->resolveAlias( $id );

        return !empty( $this->resources[ $key ] );
    }

    /**
     * Check whether a flag (i.e., one of 'shared' or 'protected') is set
     *
     * @param  string $id      Holds the name of the resource to check.
     * @param  string $method  Holds the method to delegate to
     * @param  bool   $default Holds the default return value
     * @return bool Return true if one of the flag is set, false  if not.
     * @throws KeyNotFoundException if the resource is not registered with the container.
     */
    private function hasFlag( string $id, string $method, bool $default = true ) : bool
    {
        $key = $this->resolveAlias( $id );

        if ( isset( $this->resources[ $key ] ) ) {
            return (bool) call_user_func( [ $this->resources[ $key ], $method ] );
        }

        if ( $this->parent instanceof self ) {
            return (bool) call_user_func( [ $this->parent, $method ], $key );
        }

        if ( $this->parent instanceof ContainerInterface && $this->parent->has( $key ) ) {
            // We don't know if the parent supports the 'shared' or 'protected' concept, so we assume the default
            return $default;
        }

        throw new KeyNotFoundException(
            sprintf(
                "Resource '%s' has not been registered with the container.", 
                $id
            )
        );
    }

    /**
     * Assign a tag to services.
     *
     * @param  string        $tag  Holds the tag name.
     * @param  array<string> $keys Holds the service keys to tag.
     * @return static
     */
    public function tag( string $tag, array $keys ) : static
    {
        foreach ( $keys as $key ) {
            $resolvedKey = $this->resolveAlias( $key );

            if ( ! isset( $this->tags[ $tag ] )  ) {
                $this->tags[ $tag ] = [];
            }

            $this->tags[ $tag ][] = $resolvedKey;
        }

        // Prune duplicates
        $this->tags[ $tag ] = array_unique( $this->tags[ $tag ] );

        return $this;
    }

    /**
     * Fetch all services registered to the given tag.
     *
     * @param  string $tag Holds the tag name.
     * @return array<mixed> Return an array of resolved services for the given tag
     */
    public function getTagged( string $tag ) : array
    {
        $services = [];

        if ( isset( $this->tags[ $tag ] ) ) {
            foreach ( $this->tags[ $tag] as $service ) {
                $services[] = $this->get( $service );
            }
        }

        return $services;
    }

    /**
     * Build an object of the requested class
     *
     * Creates an instance of the class specified by $id with all dependencies injected.
     * If the dependencies cannot be completely resolved, a DependencyResolutionException is thrown.
     *
     * @param  string $id     Holds the class name to build.
     * @param  bool   $shared True to create a shared resource.
     * @return mixed Return an instance of class specified by $id with all dependencies injected. Returns an object if the class exists and false otherwise
     * @throws DependencyResolutionException if the object could not be built (due to missing information)
     */
    public function buildObject( string $id, bool $shared = false ) : mixed
    {
        static $buildStack = [];

        $key = $this->resolveAlias( $id );

        if ( in_array( $key, $buildStack, true ) ) {
            $buildStack = [];

            throw new DependencyResolutionException(
                sprintf(
                    'Cannot resolve circular dependency for "%s"', 
                    $key
                )
            );
        }

        $buildStack[] = $key;

        if ( $this->has( $key ) ) {
            $resource = $this->get( $key );
            array_pop( $buildStack );

            return $resource;
        }

        try {
            $reflection = new ReflectionClass( $key );
        } catch ( ReflectionException $e ) {
            array_pop( $buildStack );

            return false;
        }

        if ( ! $reflection->isInstantiable() ) {
            $buildStack = [];

            if ( $reflection->isInterface() ) {
                throw new DependencyResolutionException(
                    sprintf(
                        'There is no service for "%s" defined, cannot autowire a class service for an interface.', 
                        $key
                    )
                );
            }

            if ( $reflection->isAbstract() ) {
                throw new DependencyResolutionException(
                    sprintf(
                        'There is no service for "%s" defined, cannot autowire an abstract class.', 
                        $key
                    )
                );
            }

            throw new DependencyResolutionException(
                sprintf(
                    '"%s" cannot be instantiated.', $key
                )
            );
        }

        $constructor = $reflection->getConstructor();

        // If there are no parameters, just return a new object.
        if ( $constructor === null ) {
            // There is no constructor, just return a new object.
            $callback = function () use ( $key ) {
                return new $key();
            };
        } else {
            $newInstanceArgs = $this->getMethodArgs( $constructor );

            $callback = function () use ( $reflection, $newInstanceArgs ) {
                return $reflection->newInstanceArgs( $newInstanceArgs );
            };
        }

        $this->set( $key, $callback, $shared );

        $resource = $this->get( $key );
        array_pop( $buildStack );

        return $resource;
    }

    /**
     * Convenience method for building a shared object.
     *
     * @param  string $id  The class name to build.
     * @return object|false Return an instance of class specified by $id with all dependencies injected. Returns an object if the class exists and false otherwise
     */
    public function buildSharedObject( string $id ) : mixed
    {
        $result = $this->buildObject($id, true);
        
        return is_object($result) ? $result : false;
    }

    /**
     * Create a child Container with a new property scope that has the ability to access the parent scope when resolving.
     *
     * @return Container Return a new dependency injection container with the current as a parent
     */
    public function createChild() : Container
    {
        return new static( $this );
    }

    /**
     * Extend a defined service Closure by wrapping the existing one with a new callable function.
     *
     * This works very similar to a decorator pattern.  Note that this only works on service Closures
     * that have been defined in the current container, not parent containers.
     *
     * @param  string   $id       Holds rhe unique identifier for the Closure or property.
     * @param  callable $callable Holds a callable to wrap the original service Closure.
     * @return void
     * @throws KeyNotFoundException
     */
    public function extend( string $id, callable $callable ) : void
    {
        $key      = $this->resolveAlias( $id );
        $resource = $this->getResource( $key, true );

        $closure = function ( $c ) use ( $callable, $resource ) {
            return $callable( $resource->getInstance(), $c );
        };

        $this->set( $key, $closure, $resource->isShared() );
    }

    /**
     * Build an array of method arguments.
     *
     * @param  ReflectionMethod  $method  Method for which to build the argument array.
     * @return array<mixed> Return an array of arguments to pass to the method.
     * @throws DependencyResolutionException
     */
    private function getMethodArgs( ReflectionMethod $method ) : array
    {
        $methodArgs = [];

        foreach ( $method->getParameters() as $param ) {
            // Check for a typehinted dependency
            if ( $param->hasType() ) {
                $dependency = $param->getType();

                // Don't support PHP 8 union types
                if ( $dependency instanceof ReflectionUnionType ) {
                    // If this is a nullable parameter, then don't error out
                    if ( $param->allowsNull() ) {
                        $methodArgs[] = null;

                        continue;
                    }

                    throw new DependencyResolutionException(
                        sprintf(
                            'Could not resolve the parameter "$%s" of "%s::%s()": Union typehints are not supported.',
                            $param->name,
                            $method->class,
                            $method->name
                        )
                    );
                }

                // Check for a class, if it doesn't have one then it is a scalar type, which we cannot handle if a mandatory argument
                if ( $dependency->isBuiltin() ) {
                    // If the param is optional, then fall through to the optional param handling later in this method
                    if ( ! $param->isOptional() ) {
                        $message  = 'Could not resolve the parameter "$%s" of "%s::%s()":';
                        $message .= ' Scalar parameters cannot be autowired and the parameter does not have a default value.';

                        throw new DependencyResolutionException(
                            sprintf(
                                $message,
                                $param->name,
                                $method->class,
                                $method->name
                            )
                        );
                    }
                } else {
                    $dependencyClassName = $dependency->getName();

                    // Check that class or interface exists
                    if ( ! interface_exists( $dependencyClassName ) && !class_exists( $dependencyClassName ) ) {
                        // If this is a nullable parameter, then don't error out
                        if ( $param->allowsNull() ) {
                            $methodArgs[] = null;

                            continue;
                        }

                        throw new DependencyResolutionException(
                            sprintf(
                                'Could not resolve the parameter "$%s" of "%s::%s()": The "%s" class does not exist.',
                                $param->name,
                                $method->class,
                                $method->name,
                                $dependencyClassName
                            )
                        );
                    }

                    // If the dependency class name is registered with this container or a parent, use it.
                    if ( $this->getResource( $dependencyClassName ) !== null ) {
                        $depObject = $this->get( $dependencyClassName );
                    } else {
                        try {
                            $depObject = $this->buildObject( $dependencyClassName );
                        } catch ( DependencyResolutionException $exception ) {
                            // If this is a nullable parameter, then don't error out
                            if ( $param->allowsNull() ) {
                                $methodArgs[] = null;

                                continue;
                            }

                            $message  = 'Could not resolve the parameter "$%s" of "%s::%s()":';
                            $message .= ' No service for "%s" exists and the dependency could not be autowired.';

                            throw new DependencyResolutionException(
                                sprintf(
                                    $message,
                                    $param->name,
                                    $method->class,
                                    $method->name,
                                    $dependencyClassName
                                ),
                                0,
                                $exception
                            );
                        }
                    }

                    if ( $depObject instanceof $dependencyClassName ) {
                        $methodArgs[] = $depObject;

                        continue;
                    }
                }
            }

            // If there is a default parameter and it can be read, use it.
            if ( $param->isOptional() && $param->isDefaultValueAvailable() ) {
                try {
                    $methodArgs[] = $param->getDefaultValue();

                    continue;
                } catch ( ReflectionException $exception ) {
                    throw new DependencyResolutionException(
                        sprintf(
                            'Could not resolve the parameter "$%s" of "%s::%s()": Unable to read the default parameter value.',
                            $param->name,
                            $method->class,
                            $method->name
                        ),
                        0,
                        $exception
                    );
                }
            }

            // If an untyped variadic argument, skip it
            if ( ! $param->hasType() && $param->isVariadic() ) {
                continue;
            }

            // At this point the argument cannot be resolved, most likely cause is an untyped required argument
            throw new DependencyResolutionException(
                sprintf(
                    'Could not resolve the parameter "$%s" of "%s::%s()": The argument is untyped and has no default value.',
                    $param->name,
                    $method->class,
                    $method->name
                )
            );
        }

        return $methodArgs;
    }

    /**
     * Set a resource to the container. If the value is null the resource is removed.
     *
     * @param  string  $key       Holds the name of resources key to set.
     * @param  mixed   $value     Callable function to run or string to retrieve when requesting the specified $key.
     * @param  bool    $shared    True to create and store a shared instance.
     * @param  bool    $protected True to protect this item from being overwritten. Useful for services.
     * @return static
     * @throws ProtectedKeyException if the provided key is already set and is protected.
     */
    public function set( string $key, mixed $value, bool $shared = false, bool $protected = false ) : static
    {
        $key    = $this->resolveAlias( $key );
        $hasKey = $this->has( $key );

        if ( $hasKey && $this->isLocal( $key ) && $this->isProtected( $key )) {
            throw new ProtectedKeyException(
                sprintf(
                    "Key %s is protected and can't be overwritten.", 
                    $key
                )
            );
        }

        if ( $value === null && $hasKey ) {
            unset( $this->resources[ $key ] );

            return $this;
        }

        $mode  = $shared    ? ContainerResource::SHARE   : ContainerResource::NO_SHARE;
        $mode |= $protected ? ContainerResource::PROTECT : ContainerResource::NO_PROTECT;

        $this->resources[ $key ] = new ContainerResource( $this, $value, $mode );

        return $this;
    }

    /**
     * Shortcut method for creating protected keys.
     *
     * @param  string $key    Holds the name of dataStore key to set.
     * @param  mixed  $value  Callable function to run or string to retrieve when requesting the specified $key.
     * @param  bool   $shared True to create and store a shared instance.
     * @return static
     */
    public function protect( string $key, mixed $value, bool $shared = false ) : static
    {
        return $this->set( $key, $value, $shared, true );
    }

    /**
     * Shortcut method for creating shared keys.
     *
     * @param  string $key       Holds the name of dataStore key to set.
     * @param  mixed  $value     Callable function to run or string to retrieve when requesting the specified $key.
     * @param  bool   $protected True to protect this item from being overwritten. Useful for services.
     * @return static
     */
    public function share( string $key, mixed $value, bool $protected = false ) : static
    {
        return $this->set( $key, $value, true, $protected );
    }

    /**
     * Get the raw data assigned to a key.
     *
     * @param  string $key  Holds the khe key for which to get the stored item.
     * @param  bool   $bail Throw an exception, if the key is not found
     * @return ?ContainerResource Return the resource if present, or null if instructed to not bail
     * @throws KeyNotFoundException
     */
    public function getResource( string $key, bool $bail = false ) : ?ContainerResource
    {
        if ( isset( $this->resources[ $key ] ) ) {
            return $this->resources[ $key ];
        }

        if ( $this->parent instanceof self ) {
            return $this->parent->getResource( $key );
        }

        if ( $this->parent instanceof ContainerInterface && $this->parent->has( $key ) ) {
            return new ContainerResource(
                $this, 
                $this->parent->get( $key ), 
                ContainerResource::SHARE | ContainerResource::PROTECT
            );
        }

        if ( $bail ) {
            throw new KeyNotFoundException(
                sprintf(
                    'Key %s has not been registered with the container.', $key 
                )
            );
        }

        return null;
    }

    /**
     * Method to force the container to return a new instance of the results of the callback for requested $key.
     *
     * @param  string $key Holds the name of the resources key to get.
     * @return mixed  Return results of running the callback for the specified key.
     */
    public function getNewInstance( string $key ) : mixed
    {
        $key = $this->resolveAlias( $key );

        $this->getResource( $key, true )->reset();

        return $this->get( $key );
    }

    /**
     * Register a service provider to the container.
     *
     * @param  ServiceProviderInterface $provider Holds the service provider to register.
     * @return static
     */
    public function registerServiceProvider( ServiceProviderInterface $provider ) : static
    {
        $provider->register( $this );

        return $this;
    }

    /**
     * Retrieve the keys for services assigned to this container.
     *
     * @return array<string> Return an array of jeys for services assigned to this container.
     */
    public function getKeys() : array
    {
        return array_unique(
            array_merge(
                array_keys($this->aliases), 
                array_keys($this->resources)
            )
        );
    }
}