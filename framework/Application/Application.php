<?php

namespace Framework\Application;

use Exception;
use Dotenv\Dotenv;
use Framework\Container\Container;
use Framework\Http\Response;
use Framework\Support\ServiceProviderInterface;
use Framework\Support\Facades\AliasLoader;
use Framework\Support\Facades\Router;

class Application extends Container
{
    private static $instance;

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->bind( 'paths.base', fn() => dirname( dirname ( __DIR__ ) ) );

        $basePath = $this->resolve( 'paths.base' );

        $this->configure( $basePath );
        $this->bindProviders( $basePath );
        $this->registerFacades();
    }

    private function configure( $basePath ) : void
    {
        $dotenv = Dotenv::createImmutable( $basePath );
        $dotenv->load();
    }

    private function bindProviders(string $basePath)
    {
        $config    = require "{$basePath}/config/app.php";
        $providers = $config[ 'providers' ];

        foreach ($providers as $provider) {
            $instance = new $provider;

            if ( $instance instanceof ServiceProviderInterface ) {
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

    public function bootstrap() : Response
    {
        return $this->dispatch( $this->resolve( 'paths.base' ) );
    }

    private function dispatch( string $basePath ): Response
    {
        $routes = require "{$basePath}/routes/web.php";
        $routes( Router::class );

        $response = Router::dispatch();

        if ( ! $response instanceof Response ) {
            $response = $this->resolve( 'response' )->content( $response );
        }

        return $response;
    }

    public function __clone() : void
    {
        throw new Exception(
            'You can not clone a singleton.'
        );
    }

    public function __wakeup() : void
    {
        throw new Exception(
            'You can not deserialize a singleton.'
        );
    }

    public function __sleep() : array
    {
        throw new Exception(
            'You can not serialize a singleton.'
        );
    }
}
