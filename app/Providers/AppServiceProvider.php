<?php

namespace App\Providers;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Doctrine\Repository\CustomerRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(CustomerRepositoryInterface::class, function ($app) {
            return new CustomerRepository($app['Doctrine\ORM\EntityManagerInterface']);
        });
    }
}
