<?php

namespace Framework\Support;

use Framework\Application\Application;

abstract class DriverProvider
{
    public function bind(Application $application): void
    {
        $name    = $this->name();
        $factory = $this->factory();
        $drivers = $this->drivers();

        $application->bind($name, function ($application) use ($name, $factory, $drivers) {
            foreach ($drivers as $key => $value) {
                $factory->addDriver($key, $value);
            }

            $config = config($name);
            echo $config;
            return $factory->connect($config[$config['default']]);
        });
    }

    abstract protected function name(): string;
    abstract protected function factory(): DriverFactory;
    abstract protected function drivers(): array;
}
