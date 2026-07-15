<?php

declare(strict_types=1);

namespace Modules\Vehicle\Filters;

use App\Support\Filtering\AbstractFilter;
use App\Support\Filtering\Filter;

final class VehicleFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            Filter::partial('vin'),
            Filter::partial('plate_number'),
            Filter::partial('color'),

            Filter::exact('user_id'),
            Filter::exact('brand_id'),
            Filter::exact('model_id'),
            Filter::exact('generation_id'),
            Filter::exact('engine_id'),
            Filter::exact('body_type_id'),
            Filter::exact('drive_type_id'),
            Filter::exact('vehicle_type_id'),

            Filter::exact('manufacture_year'),

            Filter::boolean('is_primary'),
        ];
    }
}
