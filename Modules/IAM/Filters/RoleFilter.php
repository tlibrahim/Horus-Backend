<?php

declare(strict_types=1);

namespace Modules\IAM\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class RoleFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('name'),
            Filter::exact('slug'),
            Filter::boolean('is_system'),
            Filter::boolean('is_active'),
        ];
    }
}
