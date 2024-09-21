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
use function array_values;
use function call_user_func;
use function is_array;
use function is_callable;
use function is_string;
use Closure;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use Framework\Container\Exceptions\DependencyResolutionException;
use Framework\Container\Exceptions\KeyNotFoundException;

/**
 * Container class.
 *
 * The `Container` class provides a basic dependency injection container for
 * managing class instances and their dependencies.
 *
 * @category    Omega
 * @package     Omega\Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Container
{
    /**
     * Binding class.
     *
     * @var array<string, callable> $bindings Holds an array of class alias to factory closure bindings.
     */
    private array $bindings = [];

    /**
     * Resolved class.
     *
     * @var array<string, mixed> $resolved Holds an array of resolved class instances by alias.
     */
    private array $resolved = [];

    /**
     * Bind the class.
     *
     * @param  string   $alias   Holds the class alias or key.
     * @param  callable $factory Holds a closure that defines how to create the class instance.
     * @return $this
     */
    public function alias( string $alias, callable $factory ) : static
    {
        $this->bindings[ $alias ] = $factory;
        $this->resolved[ $alias ] = null;

        return $this;
    }

    /**
     * Resolve the container.
     *
     * @param  string $alias Holds the class alias or key.
     * @return mixed Return the resolved class instance.
     * @throws KeyNotFoundException if the key is not bound.
     */
    public function resolve( string $alias ) : mixed
    {
        if ( ! isset( $this->bindings[ $alias ] ) ) {
            throw new DependencyResolutionException(
                $alias . 'is not bound.'
            );
        }

        if ( ! isset( $this->resolved[ $alias ] ) ) {
            $this->resolved[ $alias ] = call_user_func( $this->bindings[ $alias ], $this );
        }

        return $this->resolved[ $alias ];
    }

    /**
     * Call a callable with dependency injection.
     *
     * @param  callable|array{0: object|string, 1: string} $callable   Holds the callable function or method.
     * @param  array<string, mixed>                        $parameters Holds an associative array of additional parameters to pass.
     * @return mixed Return the result of the callable.
     * @throws ReflectionException if the callable cannot be reflected.
     * @throws DependencyResolutionException if a dependency cannot be resolved.
     * @throws InvalidArgumentException if the callable is not invocable.
     */
    public function call( callable|array $callable, array $parameters = [] ) : mixed
    {
        if ( ! is_callable( $callable ) ) {
            throw new InvalidArgumentException(
                'The provided callable is not invocable.'
            );
        }

        $reflector = $this->getReflector( $callable );

        $dependencies = [];

        foreach ( $reflector->getParameters() as $parameter ) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if ( isset( $parameters[ $name ] ) ) {
                $dependencies[ $name ] = $parameters[ $name ];
                continue;
            }

            if ( $parameter->isDefaultValueAvailable() ) {
                $dependencies[ $name ] = $parameter->getDefaultValue();
                continue;
            }

            if ( $type instanceof ReflectionNamedType ) {
                $dependencies[ $name ] = $this->resolve( (string) $type );
                continue;
            }

            throw new InvalidArgumentException(
                $name . 'cannot be resolved.'
            );
        }

        return $callable( ...array_values( $dependencies ) );
        //return call_user_func( $callable, ...array_values( $dependencies ) );
    }

    /**
     * Get reflector for the given callable.
     *
     * @param  callable|array{0: object|string, 1: string} $callable Holds the callable function or method.
     * @return ReflectionMethod|ReflectionFunction Return the reflection object for the callable.
     * @throws ReflectionException if the callable cannot be reflected.
     * @throws InvalidArgumentException if an unsupported callable type is provided.
     */
    private function getReflector( callable|array $callable ) : ReflectionMethod|ReflectionFunction
    {
        if ( is_array( $callable ) ) {

            return new ReflectionMethod( $callable[ 0 ], $callable[ 1 ] );
        } elseif ( $callable instanceof Closure || is_string( $callable ) ) {
            return new ReflectionFunction( $callable );
        }

        throw new InvalidArgumentException(
            'Unsupported callable type provided.'
        );
    }
}