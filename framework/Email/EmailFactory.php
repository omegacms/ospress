<?php

namespace Framework\Email;

use Framework\Email\Driver\PostmarkDriver;
use Exception;

class EmailFactory
{
    public function create( ?array $config = null ) : mixed
    {
        if (!isset($config['type'])) {
            throw new Exception('type is not defined');
        }

        return match ($config['type']) {
            'postmark' => new PostmarkDriver($config),
            default  => throw new Exception('unrecognised type')
        };
    }
}