<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class EngineFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::exact('generation_id'),
            Filter::partial('code'),
            Filter::partial('name'),
            Filter::exact('fuel_type_id'),
            Filter::exact('transmission_id'),
            Filter::boolean('is_active'),
        ];
    }
}
