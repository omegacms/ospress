<?php

namespace Framework\Http;

use Framework\Application\Application;
use Framework\Support\ServiceProviderInterface;

class ResponseServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application): void
    {
        $application->bind('response', function() {
            return new Response();
        });
    }
}
