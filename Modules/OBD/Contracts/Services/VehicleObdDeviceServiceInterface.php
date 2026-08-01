<?php

declare(strict_types=1);

namespace Modules\OBD\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Models\Vehicle;

interface VehicleObdDeviceServiceInterface
{
    public function pair(
        Vehicle $vehicle,
        ObdDevice $device,
        array $attributes = [],
    ): VehicleObdDevice;

    public function unpair(
        Vehicle $vehicle,
        ObdDevice $device,
        array $attributes = [],
    ): VehicleObdDevice;

    public function current(
        Vehicle $vehicle,
    ): ?VehicleObdDevice;

    public function history(
        Vehicle $vehicle,
    ): Collection;
}
