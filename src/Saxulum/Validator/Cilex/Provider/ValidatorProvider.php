<?php

namespace Saxulum\Validator\Cilex\Provider;

use Saxulum\Validator\Provider\ValidatorProvider as BaseValidatorProvider;
use Cilex\Application;
use Cilex\ServiceProviderInterface;

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
