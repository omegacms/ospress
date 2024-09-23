<?php

namespace Framework\Support\Facades;

class View extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'view';
    }
}
