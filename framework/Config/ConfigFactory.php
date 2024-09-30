<?php

namespace Framework\Config;

class ConfigFactory
{
    public function create( ?array $config = null ): mixed
    {
        return new Config();
    }
}   