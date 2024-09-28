<?php

namespace Framework\Queue;

use Framework\Queue\Driver\DatabaseDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class QueueServiceProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'queue';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'database' => function($config) {
                return new DatabaseDriver($config);
            },
        ];
    }
}
