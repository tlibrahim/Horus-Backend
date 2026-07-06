<?php

declare(strict_types=1);

namespace App\Support\Filtering;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * Apply filters to the query builder.
     */
    public function apply(Builder $builder): Builder;
}
