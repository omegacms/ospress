<?php

namespace Framework\Validation;

use Framework\Application\Application;
use Framework\Validation\Manager;
use Framework\Validation\Rule\RequiredRule;
use Framework\Validation\Rule\EmailRule;
use Framework\Validation\Rule\MinRule;
use Framework\Support\ServiceProviderInterface;

class ValidationServiceProvider implements ServiceProviderInterface
{
    public function bind(Application $application): void
    {
        $application->bind('validator', function($application) {
            $manager = new Manager();
    
            $this->bindRules($application, $manager);
    
            return $manager;
        });
    }

    private function bindRules(Application $application, Manager $manager): void
    {
        $application->bind('validation.rule.required', fn() => new RequiredRule());
        $application->bind('validation.rule.email', fn() => new EmailRule());
        $application->bind('validation.rule.min', fn() => new MinRule());

        $manager->addRule('required', $application->resolve('validation.rule.required'));
        $manager->addRule('email', $application->resolve('validation.rule.email'));
        $manager->addRule('min', $application->resolve('validation.rule.min'));
    }
}
