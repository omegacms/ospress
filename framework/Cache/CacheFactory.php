<?php

namespace Framework\Cache;

use Framework\Cache\Driver\FileDriver;
use Framework\Cache\Driver\MemcacheDriver;
use Framework\Cache\Driver\MemoryDriver;
use Exception;

class CacheFactory
{
    public function create(array $config): mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'file'     => new FileDriver($config),
            'memcache' => new MemcacheDriver($config),
            'memory'   => new MemoryDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}
