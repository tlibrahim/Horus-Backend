<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class CountryFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('name'),
            Filter::exact('iso2'),
            Filter::exact('iso3'),
            Filter::exact('phone_code'),
            Filter::exact('currency_id'),
            Filter::exact('language_id'),
            Filter::exact('timezone_id'),
            Filter::boolean('is_active'),
        ];
    }
}
