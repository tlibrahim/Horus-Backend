<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\OBD\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

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
