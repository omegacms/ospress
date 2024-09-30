<?php

namespace Framework\Cache;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Cache\CacheFactory;
use Framework\Support\ServiceProviderInterface;

class CacheServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('cache', function () {
            // Ottieni la configurazione
            $config = Config::get('cache');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new CacheFactory())->create($config[$default]);
        });
    }

}
