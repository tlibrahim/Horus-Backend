<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class ObdDeviceFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('serial_number'),
            Filter::partial('manufacturer'),
            Filter::partial('model'),

            Filter::exact('connection_type'),
            Filter::exact('status'),

            Filter::partial('firmware_version'),
            Filter::partial('hardware_version'),
        ];
    }
}
