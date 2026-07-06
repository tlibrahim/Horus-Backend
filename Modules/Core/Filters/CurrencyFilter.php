<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class CurrencyFilter extends AbstractFilter
{
    /**
     * @return array<int, Filter>
     */
    protected function filters(): array
    {
        return [
            Filter::exact('id'),
            Filter::exact('code'),
            Filter::partial('name'),
            Filter::boolean('is_active'),
            Filter::boolean('is_default'),
        ];
    }
}
