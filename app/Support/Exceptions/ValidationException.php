<?php

declare(strict_types=1);

namespace App\Support\Exceptions;

class ValidationException extends BusinessException
{
    public function __construct(
        string $title = 'Validation Failed',
        string $detail = '',
        string $type = 'https://api.horusdrive.com/problems/validation',
    ) {
        parent::__construct(
            title: $title,
            detail: $detail,
            status: 422,
            type: $type,
        );
    }
}
