<?php

namespace Saxulum\Validator\Silex\Provider;

use Saxulum\Validator\Provider\SaxulumValidatorProvider as BaseSaxulumValidatorProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SaxulumValidatorProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $validatorProvider = new BaseSaxulumValidatorProvider();
        $validatorProvider->register($app);
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app) {}
}
