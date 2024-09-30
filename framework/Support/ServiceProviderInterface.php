<?php

namespace Framework\Support;

use Framework\Application\Application;

interface ServiceProviderInterface
{
    public function bind( Application $application ) : void;
}