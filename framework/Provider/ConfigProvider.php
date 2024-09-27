<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\Support\Config;

class ConfigProvider
{
    public function bind(Application $app): void
    {
        $app->bind('config', function($app) {
            return new Config();
        });
    }
}
