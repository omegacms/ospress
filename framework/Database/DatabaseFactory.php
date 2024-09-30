<?php

namespace Framework\Database;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Exception;

class DatabaseFactory
{
    public function create(array $config): mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'sqlite' => new SqliteConnection($config),
            'mysql'  => new MysqlConnection($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}
