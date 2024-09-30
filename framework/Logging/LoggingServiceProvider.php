<?php

namespace Framework\Logging;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Support\ServiceProviderInterface;

class LoggingServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('logging', function () {
            // Ottieni la configurazione
            $config = Config::get('logging');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new LoggingFactory())->create($config[$default]);
        });
    }
}
