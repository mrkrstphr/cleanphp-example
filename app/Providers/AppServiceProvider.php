<?php

namespace App\Providers;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Doctrine\Repository\CustomerRepository;
use Illuminate\Support\ServiceProvider;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register a bunch of cool stuff.
     */
    public function register()
    {
        $this->app->bind(HydratorInterface::class, function ($app) {
            return new ClassMethods();
        });

        $this->app->bind(CustomerRepositoryInterface::class, function ($app) {
            return new CustomerRepository($app['Doctrine\ORM\EntityManagerInterface']);
        });
    }
}
