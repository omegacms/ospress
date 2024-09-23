<?php

namespace Framework\Support\Facades;

class Cache extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'cache';
    }
}