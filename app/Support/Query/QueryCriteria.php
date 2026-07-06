<?php

declare(strict_types=1);

namespace App\Support\Query;

use App\Support\Filtering\FilterInterface;

final readonly class QueryCriteria
{
    public function __construct(
        public ?FilterInterface $filter = null,
        public int $perPage = 15,
        public array $columns = ['*'],
    ) {}
}
