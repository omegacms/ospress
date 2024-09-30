<?php

namespace Framework\Config;

use Framework\Application\Application;
use Framework\Support\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application): void
    {
        $application->bind('config', function() {
            return new Config();
        });
    }
}