<?php

namespace Framework\Filesystem;

use Framework\Filesystem\Driver\LocalDriver;
use Exception;

class FilesystemFactory
{
    public function create( ?array $config = null ) : mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'local' => new LocalDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}