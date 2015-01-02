<?php

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'customers' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/customers',
                    'defaults' => [
                        'controller' => 'Application\Controller\Customers',
                        'action'     => 'index',
                    ],
                ],
            ],
            'orders' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/orders',
                    'defaults' => [
                        'controller' => 'Application\Controller\Orders',
                        'action'     => 'index',
                    ],
                ],
            ],
            'invoices' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/invoices',
                    'defaults' => [
                        'controller' => 'Application\Controller\Invoices',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ],
        'factories' => [
            'Application\Controller\Customers' => function ($sm) {
                return new \Application\Controller\CustomersController(
                    $sm->getServiceLocator()->get('CustomerTable')
                );
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
