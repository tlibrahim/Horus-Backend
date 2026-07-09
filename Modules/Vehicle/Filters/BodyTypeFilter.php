<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class BodyTypeFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('name'),
            Filter::exact('slug'),
            Filter::boolean('is_active'),
        ];
    }
}
