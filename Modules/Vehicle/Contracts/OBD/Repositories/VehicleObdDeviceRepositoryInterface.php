<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\OBD\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

interface VehicleObdDeviceRepositoryInterface extends CrudRepositoryInterface
{
    public function activeForVehicle(Vehicle $vehicle): ?VehicleObdDevice;

    public function activeForDevice(ObdDevice $device): ?VehicleObdDevice;

    public function activePairing(Vehicle $vehicle, ObdDevice $device): ?VehicleObdDevice;

    public function history(Vehicle $vehicle): Collection;
}
