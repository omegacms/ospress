<?php

namespace App\Http\Controllers\Products;

use Framework\Support\Facades\Response;
use Framework\Support\Facades\Router;
use Framework\Support\Facades\Session;

class OrderProductController
{
    public function handle()
    {
        secure();

        // use $data to create a database record...

        Session::put( 'ordered', true );

        return Response::redirect(Router::route('show-home-page'));
    }
}
