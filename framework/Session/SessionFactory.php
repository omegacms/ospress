<?php

namespace Framework\Session;

use Framework\Session\Driver\NativeDriver;
use Exception;

class SessionFactory
{
    public function create( ?array $config = null ) : mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'native' => new NativeDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}