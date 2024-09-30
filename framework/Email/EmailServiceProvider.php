<?php

namespace Framework\Email;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Support\ServiceProviderInterface;

class EmailServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('email', function () {
            // Ottieni la configurazione
            $config = Config::get('email');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new EmailFactory())->create($config[$default]);
        });
    }
}