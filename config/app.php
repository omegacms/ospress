<?php

return [
    'providers' => [
        \Framework\Config\ConfigServiceProvider::class,
        \Framework\Cache\CacheServiceProvider::class,
        \Framework\Database\DatabaseServiceProvider::class,
        \Framework\Email\EmailServiceProvider::class,
        \Framework\Filesystem\FilesystemServiceProvider::class,
        \Framework\Logging\LoggingServiceProvider::class,
        \Framework\Queue\QueueServiceProvider::class,
        \Framework\Http\ResponseServiceProvider::class,
        \Framework\Routing\RouterServiceProvider::class,
        \Framework\Session\SessionServiceProvider::class,
        \Framework\Validation\ValidationServiceProvider::class,
        \Framework\View\ViewServiceProvider::class,
    ],
    'facades'   => [
        'Config'     => \Framework\Support\Facades\Config::class,
        'Cache'      => \Framework\Support\Facades\Cache::class,
        'Database'   => \Framework\Support\Facades\Database::class,
        'Email'      => \Framework\Support\Facades\Email::class,
        'Filesystem' => \Framework\Support\Facades\Filesystem::class,
        'Logging'    => \Framework\Support\Facades\Logging::class,
        'Queue'      => \Framework\Support\Facades\Queue::class,
        'Response'   => \Framework\Support\Facades\Response::class,
        'Router'     => \Framework\Support\Facades\Router::class,
        'Session'    => \Framework\Support\Facades\Session::class,
        'Validator'  => \Framework\Support\Facades\Validation::class,
        'View'       => \Framework\Support\Facades\View::class
    ],
];