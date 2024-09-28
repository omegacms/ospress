<?php

namespace Framework\Database;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class DatabaseServiceProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'database';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'sqlite' => function($config) {
                return new SqliteConnection($config);
            },
            'mysql' => function($config) {
                return new MysqlConnection($config);
            },
        ];
    }
}
