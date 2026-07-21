<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\OBD\Repositories\VehicleObdDeviceRepositoryInterface;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

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
