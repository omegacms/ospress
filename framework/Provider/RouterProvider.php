<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\Routing\Router;

class RouterProvider
{
    public function bind( Application $app ) : void
    {   
        $app->bind( 'router', function ( $app ) {
            return new Router();
        });
    }   
}
