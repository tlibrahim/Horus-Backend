<?php

declare(strict_types=1);

namespace App\Support\Exceptions;

use Exception;

class BusinessException extends Exception
{
    public function __construct(
        protected string $title = 'Business Rule Violation',
        protected string $detail = '',
        protected int $status = 409,
        protected string $type = 'https://api.horusdrive.com/problems/business-rule',
    ) {
        parent::__construct($detail, $status);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function detail(): string
    {
        return $this->detail;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function type(): string
    {
        return $this->type;
    }
}
