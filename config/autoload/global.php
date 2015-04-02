<?php

use CleanPhp\Invoicer\Persistence\Hydrator\OrderHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

return [
    'service_manager' => [
        'factories' => [
            'OrderHydrator' => function ($sm) {
                return new OrderHydrator(
                    new ClassMethods(),
                    $sm->get('CustomerRepository')
                );
            },
            'CustomerRepository' =>
                'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
            'InvoiceRepository' =>
                'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
            'OrderRepository' =>
                'CleanPhp\Invoicer\Persistence\Doctrine\Repository\RepositoryFactory',
        ]
    ],
];
