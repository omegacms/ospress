<?php

namespace Framework\Config;

use Framework\Application\Application;

class ConfigServiceProvider
{
    public function bind(Application $application): void
    {
        $application->bind('config', function($application) {
            return new Config();
        });
    }
}
