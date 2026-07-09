<?php

declare(strict_types=1);

return [
    'core' => [
        'countries' => ['view', 'create', 'update', 'delete'],
        'cities' => ['view', 'create', 'update', 'delete'],
        'districts' => ['view', 'create', 'update', 'delete'],
        'currencies' => ['view', 'create', 'update', 'delete'],
        'languages' => ['view', 'create', 'update', 'delete'],
        'timezones' => ['view', 'create', 'update', 'delete'],
    ],

    'iam' => [
        'users' => ['view', 'create', 'update', 'delete'],
        'roles' => ['view', 'create', 'update', 'delete'],
        'permissions' => ['view', 'assign'],
    ],

    'vehicle' => [
        'brands' => ['view', 'create', 'update', 'delete'],
        'models' => ['view', 'create', 'update', 'delete'],
        'generations' => ['view', 'create', 'update', 'delete'],
        'engines' => ['view', 'create', 'update', 'delete'],
    ],
];
