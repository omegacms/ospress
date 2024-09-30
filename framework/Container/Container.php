<?php

namespace Framework\Container;

use InvalidArgumentException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use Closure;
use Exception;

class Container
{
    private array $bindings = [];
    private array $resolved = [];
    public array $drivers;

    public function bind(string $alias, callable $factory): static
    {
        $this->bindings[$alias] = $factory;
        $this->resolved[$alias] = null;

        return $this;
    }

    public function resolve(string $alias): mixed
    {
        if (!isset($this->bindings[$alias])) {
            throw new InvalidArgumentException("{$alias} is not bound");
        }

        if (!isset($this->resolved[$alias])) {
            $this->resolved[$alias] = call_user_func($this->bindings[$alias], $this);
        }

        return $this->resolved[$alias];
    }

    public function has(string $alias): bool
    {
        return isset($this->bindings[$alias]);
    }

    public function call(array|callable $callable, array $parameters = []): mixed
    {
        $reflector = $this->getReflector($callable);

        $dependencies = [];

        foreach ($reflector->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (isset($parameters[$name])) {
                $dependencies[$name] = $parameters[$name];
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[$name] = $parameter->getDefaultValue();
                continue;
            }

            if ($type instanceof ReflectionNamedType) {
                $dependencies[$name] = $this->resolve($type);
                continue;
            }

            throw new InvalidArgumentException("{$name} cannot be resolved");
        }

        return call_user_func($callable, ...array_values($dependencies));
    }

    private function getReflector(array|callable $callable): ReflectionMethod|ReflectionFunction
    {
        if (is_array($callable)) {
            return new ReflectionMethod($callable[0], $callable[1]);
        }

        return new ReflectionFunction($callable);
    }

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }
    
    public function connect(array $config): mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }
    
        $type = $config['type'];
    
        if (isset($this->drivers[$type])) {
            return $this->drivers[$type]($config); // Usa i driver registrati nel container
        }
    
        throw new Exception('unrecognised type');
    }
}
