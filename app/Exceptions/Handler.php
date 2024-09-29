<?php

namespace App\Exceptions;

use Framework\Support\Exception\ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function showThrowable(Throwable $throwable)
    {
        // add in some reporting...

        return parent::showThrowable($throwable);
    }
}
