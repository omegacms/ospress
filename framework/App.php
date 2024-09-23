<?php

namespace Framework;

use Dotenv\Dotenv;
use Framework\Routing\Router;
use Framework\Http\Response;
use Framework\Support\Facades\AliasLoader;

class App extends Container
{
    private static $instance;

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct() {}
    private function __clone() {}

    public function prepare(): static
    {
        $basePath = $this->resolve('paths.base');

        $this->configure($basePath);
        $this->bindProviders($basePath);
        $this->registerFacades();

        return $this;
    }

    public function run(): Response
    {
        return $this->dispatch($this->resolve('paths.base'));
    }

    private function configure(string $basePath)
    {
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }

    private function bindProviders(string $basePath)
    {
        $config    = require "{$basePath}/config/app.php";
        $providers = $config[ 'providers' ];

        foreach ($providers as $provider) {
            $instance = new $provider;

            if (method_exists($instance, 'bind')) {
                $instance->bind($this);
            }
        }
    }

    private function registerFacades(): void
    {
        $config = require $this->resolve('paths.base') . '/config/app.php';
        $aliases = $config['facades'];

        AliasLoader::getInstance($aliases)->load();
    }

    private function dispatch(string $basePath): Response
    {
        if (!$this->has(Router::class)) {
            $router = new Router();

            $routes = require "{$basePath}/app/routes.php";
            $routes($router);

            $this->bind(Router::class, fn() => $router);
        }

        $response = $this->resolve(Router::class)->dispatch();

        if (!$response instanceof Response) {
            $response = $this->resolve('response')->content($response);
        }

        return $response;
    }
}
