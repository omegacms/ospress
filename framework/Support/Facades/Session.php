<?php

namespace Framework\Support\Facades;

class Session extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'session';
    }
}