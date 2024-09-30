<?php

namespace Framework\Routing;

use Framework\Application\Application;
use Framework\Support\ServiceProviderInterface;

class RouterServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application): void
    {
        $application->bind('router', function() {
            return new Router();
        });
    }
}