<?php

namespace Framework\Support\Facades;

class Queue extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'queue';
    }
}
