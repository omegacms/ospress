<?php

namespace Framework\Queue;

use Framework\Queue\Driver\DatabaseDriver;
use Exception;

class QueueFactory
{
    public function create( ?array $config = null ) : mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'database' => new DatabaseDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}
