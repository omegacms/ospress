<?php

namespace Framework\Routing;

use Framework\Application\Application;

class RouterServiceProvider
{
    public function bind( Application $application ) : void
    {   
        $application->bind( 'router', function ( $application ) {
            return new Router();
        });
    }   
}
