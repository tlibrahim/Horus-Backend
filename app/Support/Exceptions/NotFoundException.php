<?php

declare(strict_types=1);

namespace App\Support\Exceptions;

class NotFoundException extends BusinessException
{
    public function __construct(
        string $title = 'Resource Not Found',
        string $detail = '',
        string $type = 'https://api.horusdrive.com/problems/not-found',
    ) {
        parent::__construct(
            title: $title,
            detail: $detail,
            status: 404,
            type: $type,
        );
    }
}
