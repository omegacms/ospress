<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\Support\Config;

class ConfigProvider
{
    public function bind(Application $application): void
    {
        $application->bind('config', function($application) {
            return new Config();
        });
    }
}
