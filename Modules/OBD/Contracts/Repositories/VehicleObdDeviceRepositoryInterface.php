<?php

declare(strict_types=1);

namespace Modules\OBD\Contracts\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Models\Vehicle;

interface VehicleObdDeviceRepositoryInterface extends CrudRepositoryInterface
{
    public function activeForVehicle(Vehicle $vehicle): ?VehicleObdDevice;

    public function activeForDevice(ObdDevice $device): ?VehicleObdDevice;

    public function activePairing(Vehicle $vehicle, ObdDevice $device): ?VehicleObdDevice;

    public function history(Vehicle $vehicle): Collection;
}
