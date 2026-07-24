<?php

declare(strict_types=1);

namespace App\Support\Exceptions;

class ForbiddenException extends BusinessException
{
    public function __construct(
        string $title = 'Forbidden',
        string $detail = '',
        string $type = 'https://api.horusdrive.com/problems/forbidden',
    ) {
        parent::__construct(
            title: $title,
            detail: $detail,
            status: 403,
            type: $type,
        );
    }
}
