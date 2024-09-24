<?php

namespace Framework\Support\Facades;

class Router extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'router';
    }
}