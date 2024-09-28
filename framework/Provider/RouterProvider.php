<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\Routing\Router;

class RouterProvider
{
    public function bind( Application $application ) : void
    {   
        $application->bind( 'router', function ( $application ) {
            return new Router();
        });
    }   
}
