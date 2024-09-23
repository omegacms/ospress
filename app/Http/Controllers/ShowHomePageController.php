<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Framework\Routing\Router;
use Framework\Support\Facades\Config;
use Framework\Support\Facades\Cache;
use Framework\Support\Facades\Filesystem;
use Framework\Support\Facades\Session;

class ShowHomePageController
{
    public function handle(Router $router)
    {
        $cache = app('cache');
        $products = Product::all();

        $productsWithRoutes = array_map(function ($product) use ($router, $cache) {
            $key = "route-for-product-{$product->id}";

            if (!$cache->has($key)) {
                $cache->put($key, $router->route('view-product', ['product' => $product->id]));
            }

            $product->route = $cache->get($key);

            return $product;
        }, $products);

        // Facade test
        require $_SERVER[ 'DOCUMENT_ROOT' ] . '/config/database.php';
        echo "Database: " . Config::get( 'database.default' );

        Cache::put( 'test', 'Questo e un test' );
        echo "Cache: " . Cache::get( 'test' );

        Session::put( 'key', 'Sessione Impostata' );
        echo Session::get( 'key' );

        if ( ! Filesystem::exists( 'hits.txt', '' ) ) {
            Filesystem::put( 'hits.txt', 'Ciao Mondo!' );
        }
        // Facade test


        // app('queue')->push(
        //     fn($name) => app('logging')->info("Hello {$name}"),
        //     'Chris',
        // );

        // app('logging')->info('Send a task into the background');

        // app('queue')->push(
        //     fn($name) => app('email')
        //         ->to('cgpitt@gmail.com')
        //         ->text("Hello {$name}")
        //         ->send(),
        //     'Chris',
        // );

        return view('home', [
            'products' => $productsWithRoutes,
        ]);
    }
}
