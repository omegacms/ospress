<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Routing\Router;

class RouterProvider
{
    public function bind( App $app ) : void
    {   
        $app->bind( 'router', function ( $app ) {
            return new Router();
        });
    }   
}