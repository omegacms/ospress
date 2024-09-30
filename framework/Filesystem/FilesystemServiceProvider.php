<?php

namespace Framework\Filesystem;

use Framework\Application\Application;
use Framework\Support\Facades\Config;
use Framework\Support\ServiceProviderInterface;

class FilesystemServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application) : void // Non deve ritornare un factory
    {
        $application->bind('filesystem', function () {
            // Ottieni la configurazione
            $config = Config::get('filesystem');
    
            // Estrai il valore di default dal campo 'default'
            $default = $config['default'];
    
            // Passa la configurazione corretta alla factory
            return (new FilesystemFactory())->create($config[$default]);
        });
    }
}