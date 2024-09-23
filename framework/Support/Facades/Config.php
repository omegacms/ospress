<?php

namespace Framework\Support\Facades;

class Config extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'config';
    }
}