<?php

namespace App\Http\Controllers;

use function array_map;
use App\Models\Product;
use Framework\Support\Facades\Cache;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\View;

class ShowHomePageController
{
    public function handle() : \Framework\View\View
    {
        $products = Product::all();

        $productsWithRoutes = array_map(function ($product) {
            $key = "route-for-product-{$product->id}";

            if (!Cache::has($key)) {
                Cache::put($key, Router::route('view-product', ['product' => $product->id]));
            }

            $product->route = Cache::get($key);

            return $product;
        }, $products);

        return View::render('home', [
            'products' => $productsWithRoutes,
        ]);
    }
}
