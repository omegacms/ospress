Questa e' l'architettura che intendevo fin dal principio.

Per prima cosa una modifica alla classe `App`.

```php
private function bindProviders(string $basePath)
{
    $config    = require "{$basePath}/config/app.php";
    $providers = $config[ 'providers' ];

    foreach ($providers as $provider) {
        $instance = new $provider;

        // Nella clsse Container un metodo bind esiste,
        // quindi questo viene rinominato in `register.
        if (method_exists($instance, 'register')) {
            $instance->register($this);
        }
    }
}
```

L'architettura del pacchetto `Container` che vorrei e' la seguente;

`ContainerInterface`

```php
namespace Framework\Container;

use Psr\Container\ContainerInterface as PsrContainer;

interface ContainerInterface extends PsrContainer
{
    // Qua i metodi che andranno nell'interfaccia.
}
```

`Container`

Il container a questo punto non e' piu' una classe astratta, ma concreta.

```php
namespace Framework\Container;

use InvalidArgumentException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;

class Container implements ContainerInterface
{   
    private array $drivers  = [];
    private array $bindings = [];
    private array $resolved = [];

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

    public function register(App $app): void
    {
        $name = $this->name();
        $factory = $this->factory();
        $drivers = $this->drivers();

        $app->bind($name, function ($app) use ($name, $factory, $drivers) {
            foreach ($drivers as $key => $value) {
                $factory->addDriver($key, $value);
            }

            $config = config($name);

            return $factory->connect($config[$config['default']]);
        });
    }

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }


    public function connect(array $config): mixed
    {
        $type = $config['type'] ?? null;

        if (!$type || !isset($this->bindings[$type])) {
            throw new \RuntimeException('Unknown driver type or type not specified.');
        }

        return $this->bindings[$type]($config);
    }
}
```

`ServiceProviderInterface`

```php
namespace Framework\Container;

interface ServiceProviderInterface
{

    public function name(): string;
    public function factory();
}
```

`DatabaseServiceProvider`
```php
namespace Framework\Provider;

use Framework\Container\ServiceProviderInterface;
use Framework\Database\DatabaseFactory;

class DatabaseProvider implements ServiceProviderInterface
{
    public function name() : string
    {
        return 'database';
    }

    public function factory()
    {
        // Da questo metodo si richiama la classe DatabaseFactory
        // passandogli l'array config.
        new DatabaseFactory( $config );
    }
}
```

`FactoryInterface`

```php
namespace Framework\Support\Factory;

interface FactoryInterface
{
    public function create();
}
```

`AbstractFactory`

```php
namespace Framework\SupportFactory;

abstract class AbstractFactory implements FactoryInterface
{
    abstract public function create();
}
```

`DatabaseFactory`

```php
namespace Framework\Database;

use Framework\Support\Factory\AbstractFactory;

class DatabaseFactory extends AstractFactory
{
    public function create()
    {
        // Qua avviene la creazione dell'istanza.
    }
}
```

Questa e' a grandi linee l'architettura che mi piacerebbe realizzare.
Sono consapevole che ci sono molti type hinting da sistemare in modo appropriato per escludere il
metodo `drivers` che non serve piu e dargli una logica diversa.

Cosa ne pensi?

Non ci siano. Stiamo facendo un gran pastrocchio, quindi inizio con alcune informazioni di base.

1) La class `App` estende la classe `Container`, quindi tutti i metodi del container sono disponibili mmediante `$app->nome_metodo`.

2) Il metodo `bindProviders` della classe `App` prende in input un'array di providers e per ognuno 