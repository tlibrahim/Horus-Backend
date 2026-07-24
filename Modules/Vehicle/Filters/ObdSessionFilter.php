<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class ObdSessionFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::exact('vehicle_obd_device_id'),

            Filter::exact('connection_type'),

            Filter::exact('status'),

            Filter::dateFrom('started_at'),

            Filter::dateTo('started_at'),

            Filter::dateFrom('last_activity_at'),

            Filter::dateTo('last_activity_at'),
        ];
    }
}
