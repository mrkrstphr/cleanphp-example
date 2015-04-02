<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => [
                    'path' => __DIR__ . '/../../data/database.db',
                ]
            ]
        ],
    ],
];
