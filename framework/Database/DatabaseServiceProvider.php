<?php

namespace Framework\Database;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Database\DatabaseFactory;
use Framework\Support\ServiceProviderInterface;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('database', function () {
            // Ottieni la configurazione
            $config = Config::get('database');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new DatabaseFactory())->create($config[$default]);
        });
    }
}
