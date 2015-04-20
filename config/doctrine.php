<?php

return [
    // database connection information is managed in Laravel's config/database.php file

    'proxies_dir' => app()->databasePath() . '/Proxies',
    'mappings' => [
        'type' => 'yaml',
        'namespace' => 'CleanPhp\Invoicer\Domain\Entity',
        'paths' => [__DIR__ . '/../core/Persistence/Doctrine/Mapping']
    ],
];
