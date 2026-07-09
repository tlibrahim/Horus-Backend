<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class VehicleModelFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::exact('brand_id'),
            Filter::partial('name'),
            Filter::exact('slug'),
            Filter::boolean('is_active'),
        ];
    }
}
