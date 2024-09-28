<?php

namespace Framework\Http;

use Framework\Application\Application;

class ResponseServiceProvider
{
    public function bind(Application $application): void
    {
        $application->bind('response', function($application) {
            return new Response();
        });
    }
}
