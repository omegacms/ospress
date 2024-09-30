<?php

namespace Framework\Support\Factory;

interface GenericFactoryInterface
{
    public function create( array $config ) : mixed;
}