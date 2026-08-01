<?php

declare(strict_types=1);

namespace Modules\OBD\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Contracts\Repositories\VehicleObdDeviceRepositoryInterface;
use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Models\Vehicle;

final class VehicleObdDeviceRepository extends BaseRepository implements VehicleObdDeviceRepositoryInterface
{
    protected function model(): string
    {
        return VehicleObdDevice::class;
    }

    public function activeForVehicle(
        Vehicle $vehicle,
    ): ?VehicleObdDevice {
        /** @var VehicleObdDevice|null */
        return VehicleObdDevice::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('is_active', true)
            ->first();
    }

    public function activeForDevice(
        ObdDevice $device,
    ): ?VehicleObdDevice {
        /** @var VehicleObdDevice|null */
        return VehicleObdDevice::query()
            ->where('obd_device_id', $device->id)
            ->where('is_active', true)
            ->first();
    }

    public function activePairing(
        Vehicle $vehicle,
        ObdDevice $device,
    ): ?VehicleObdDevice {
        /** @var VehicleObdDevice|null */
        return VehicleObdDevice::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('obd_device_id', $device->id)
            ->where('is_active', true)
            ->first();
    }

    public function history(
        Vehicle $vehicle,
    ): Collection {
        return VehicleObdDevice::query()
            ->where('vehicle_id', $vehicle->id)
            ->latest('paired_at')
            ->get();
    }
}
