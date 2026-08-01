<?php

declare(strict_types=1);

return [
    'roles' => require __DIR__.'/roles.php',
    'admin' => require __DIR__.'/admin.php',
    'permissions' => require __DIR__.'/permissions.php',

    'role_permissions' => [
        'Developer' => [
            'auth.logs.view',
            'auth.queue.view',
            'auth.horizon.view',
            'auth.jobs.view',
            'auth.jobs.retry',
            'auth.jobs.delete',
            'auth.system-settings.view',
            'auth.system-settings.update',
        ],
    ],

    'jwt_secret' => env('AUTH_JWT_SECRET'),
    'access_token_ttl_minutes' => 15,
    'refresh_token_ttl_days' => 30,
    'otp_ttl_minutes' => 10,
    'otp_max_verify_attempts' => 5,
    'otp_issue_max_attempts' => 3,
    'otp_issue_decay_seconds' => 60,
];
