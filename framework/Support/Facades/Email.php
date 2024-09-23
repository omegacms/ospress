<?php

namespace Framework\Support\Facades;

class Email extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'email';
    }
}
