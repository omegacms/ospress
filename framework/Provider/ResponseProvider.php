<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\Http\Response;

class ResponseProvider
{
    public function bind(Application $application): void
    {
        $application->bind('response', function($application) {
            return new Response();
        });
    }
}
