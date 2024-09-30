<?php

namespace Framework\Logging;

use Framework\Logging\Driver\StreamDriver;
use Exception;

class LoggingFactory
{
    public function create( ?array $config = null ) : mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'stream' => new StreamDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}