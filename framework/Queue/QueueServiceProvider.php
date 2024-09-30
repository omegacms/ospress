<?php

namespace Framework\Queue;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Support\ServiceProviderInterface;

class QueueServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('queue', function () {
            // Ottieni la configurazione
            $config = Config::get('queue');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new QueueFactory())->create($config[$default]);
        });
    }
}
