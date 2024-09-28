<?php

namespace Framework\Provider;

use Framework\Application\Application;
use Framework\View\Manager;
use Framework\View\Engine\BasicEngine;
use Framework\View\Engine\AdvancedEngine;
use Framework\View\Engine\PhpEngine;
use Framework\View\Engine\LiteralEngine;

class ViewProvider
{
    public function bind(Application $application): void
    {
        $application->bind('view', function($application) {
            $manager = new Manager();
    
            $this->bindPaths($application, $manager);
            $this->bindMacros($application, $manager);
            $this->bindEngines($application, $manager);
    
            return $manager;
        });
    }

    private function bindPaths(Application $application, Manager $manager): void
    {
        $manager->addPath($application->resolve('paths.base') . '/resources/views');
        $manager->addPath($application->resolve('paths.base') . '/resources/images');
    }

    private function bindMacros(Application $application, Manager $manager): void
    {
        $manager->addMacro('escape', fn($value) => htmlspecialchars($value, ENT_QUOTES));
        $manager->addMacro('includes', fn(...$params) => print view(...$params));
    }

    private function bindEngines(Application $application, Manager $manager): void
    {
        $application->bind('view.engine.basic', fn() => new BasicEngine());
        $application->bind('view.engine.advanced', fn() => new AdvancedEngine());
        $application->bind('view.engine.php', fn() => new PhpEngine());
        $application->bind('view.engine.literal', fn() => new LiteralEngine());

        $manager->addEngine('basic.php', $application->resolve('view.engine.basic'));
        $manager->addEngine('advanced.php', $application->resolve('view.engine.advanced'));
        $manager->addEngine('php', $application->resolve('view.engine.php'));
        $manager->addEngine('svg', $application->resolve('view.engine.literal'));
    }
}
