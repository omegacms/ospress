<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\View;

class ShowProductController
{
    public function handle()
    {
        $parameters = Router::current()->parameters();

        $product = Product::find((int) $parameters['product']);

        return View::view('products/view', [
            'product'     => $product,
            'orderAction' => Router::route('order-product', ['product' => $product->id]),
            'csrf'        => csrf(),
        ]);
    }
}
