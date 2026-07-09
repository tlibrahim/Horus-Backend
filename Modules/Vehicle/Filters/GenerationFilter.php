<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class GenerationFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::exact('model_id'),
            Filter::partial('name'),
            Filter::exact('start_year'),
            Filter::exact('end_year'),
            Filter::boolean('is_active'),
        ];
    }
}
