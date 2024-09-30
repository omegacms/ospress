<?php

namespace Framework\Support\Facades;

class Validation extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'validator';
    }
}
