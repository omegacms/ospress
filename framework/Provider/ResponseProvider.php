<?php

namespace Framework\Provider;

use Framework\Application;
use Framework\Http\Response;

class ResponseProvider
{
    public function bind(Application $app): void
    {
        $app->bind('response', function($app) {
            return new Response();
        });
    }
}
