<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class DistrictFilter extends AbstractFilter
{
    /**
     * @return array<int, Filter>
     */
    protected function filters(): array
    {
        return [
            Filter::exact('id'),
            Filter::exact('city_id'),
            Filter::partial('name'),
            Filter::exact('postal_code'),
            Filter::boolean('is_active'),
        ];
    }
}
