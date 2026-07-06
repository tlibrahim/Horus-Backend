<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class TimezoneFilter extends AbstractFilter
{
    /**
     * @return array<int, Filter>
     */
    protected function filters(): array
    {
        return [
            Filter::exact('id'),
            Filter::partial('name'),
            Filter::exact('utc_offset'),
            Filter::boolean('is_active'),
        ];
    }
}
