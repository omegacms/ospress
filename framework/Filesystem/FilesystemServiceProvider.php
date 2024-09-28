<?php

namespace Framework\Filesystem;

use Framework\Filesystem\Driver\LocalDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class FilesystemServiceProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'filesystem';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'local' => function($config) {
                return new LocalDriver($config);
            },
        ];
    }
}
