<?php

namespace Framework\Provider;

use Framework\Application;
use Framework\Routing\Router;

class RouterProvider
{
    public function bind( Applicstion $app ) : void
    {   
        $app->bind( 'router', function ( $app ) {
            return new Router();
        });
    }   
}
