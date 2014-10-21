<?php

namespace Saxulum\Validator\Silex\Provider;

use Saxulum\Validator\Provider\ValidatorProvider as BaseValidatorProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ValidatorProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $validatorProvider = new BaseValidatorProvider();
        $validatorProvider->register($app);
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app) {}
}
