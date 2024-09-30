<?php

namespace Framework\Session;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Support\ServiceProviderInterface;

class SessionServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('session', function () {
            // Ottieni la configurazione
            $config = Config::get('session');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new SessionFactory())->create($config[$default]);
        });
    }
}
