<?php

declare(strict_types=1);

namespace App\Support\Exceptions;

class ConflictException extends BusinessException
{
    public function __construct(
        string $title = 'Conflict',
        string $detail = '',
        string $type = 'https://api.horusdrive.com/problems/conflict',
    ) {
        parent::__construct(
            title: $title,
            detail: $detail,
            status: 409,
            type: $type,
        );
    }
}
