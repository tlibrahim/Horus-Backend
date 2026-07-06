<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class CityFilter extends AbstractFilter
{
    /**
     * @return array<int, Filter>
     */
    protected function filters(): array
    {
        return [
            Filter::exact('id'),
            Filter::exact('country_id'),
            Filter::partial('name'),
            Filter::boolean('is_active'),
        ];
    }
}
