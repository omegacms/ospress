<?php

use Framework\Provider\ConfigProvider;
use Framework\Provider\CacheProvider;
use Framework\Provider\DatabaseProvider;
use Framework\Provider\EmailProvider;
use Framework\Provider\FilesystemProvider;
use Framework\Provider\LoggingProvider;
use Framework\Provider\QueueProvider;
use Framework\Provider\ResponseProvider;
use Framework\Provider\SessionProvider;
use Framework\Provider\ValidationProvider;
use Framework\Provider\ViewProvider;
use Framework\Support\Facades\Config;
use Framework\Support\Facades\Cache;
use Framework\Support\Facades\Database;
use Framework\Support\Facades\Email;
use Framework\Support\Facades\Filesystem;
use Framework\Support\Facades\Logging;
use Framework\Support\Facades\Queue;
use Framework\Support\Facades\Response;
use Framework\Support\Facades\Session;
use Framework\Support\Facades\Validation;
use Framework\Support\Facades\View;

return [
    'providers' => [
        ConfigProvider::class,
        CacheProvider::class,
        DatabaseProvider::class,
        EmailProvider::class,
        FilesystemProvider::class,
        LoggingProvider::class,
        QueueProvider::class,
        ResponseProvider::class,
        SessionProvider::class,
        ValidationProvider::class,
        ViewProvider::class,
    ],
    'facades'   => [
        'Config'     => Config::class,
        'Cache'      => Cache::class,
        'Database'   => Database::class,
        'Email'      => Email::class,
        'Filesystem' => Filesystem::class,
        'Logging'    => Logging::class,
        'Queue'      => Queue::class,
        'Response'   => Response::class,
        'Session'    => Session::class,
        'Validation' => Validation::class,
        'View'       => View::class
    ],
];