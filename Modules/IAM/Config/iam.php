<?php

declare(strict_types=1);

return [
    'roles' => require __DIR__.'/roles.php',
    'admin' => require __DIR__.'/admin.php',
    'permissions' => require __DIR__.'/permissions.php',

    'role_permissions' => [
        'Developer' => [
            'iam.logs.view',
            'iam.queue.view',
            'iam.horizon.view',
            'iam.jobs.view',
            'iam.jobs.retry',
            'iam.jobs.delete',
            'iam.system-settings.view',
            'iam.system-settings.update',
        ],
    ],

    'auth' => [
        'jwt_secret' => env('IAM_JWT_SECRET'),
        'access_token_ttl_minutes' => 15,
        'refresh_token_ttl_days' => 30,
        'otp_ttl_minutes' => 10,
        'otp_max_verify_attempts' => 5,
        'otp_issue_max_attempts' => 3,
        'otp_issue_decay_seconds' => 60,
    ],
];
