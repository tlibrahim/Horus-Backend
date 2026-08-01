<?php

declare(strict_types=1);

namespace Modules\Auth\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class PermissionFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('name'),
            Filter::exact('code'),
            Filter::exact('group'),
        ];
    }
}
