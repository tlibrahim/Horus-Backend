<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Exceptions\BusinessException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Vehicle\Contracts\OBD\Repositories\VehicleObdDeviceRepositoryInterface;
use Modules\Vehicle\Contracts\OBD\Services\VehicleObdDeviceServiceInterface;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

final readonly class VehicleObdDeviceService implements VehicleObdDeviceServiceInterface
{
    public function __construct(
        private VehicleObdDeviceRepositoryInterface $repository,
    ) {}

    public function pair(
        Vehicle $vehicle,
        ObdDevice $device,
        array $attributes = [],
    ): VehicleObdDevice {
        return DB::transaction(function () use (
            $vehicle,
            $device,
            $attributes,
        ): VehicleObdDevice {

            // Device is already paired to another vehicle.
            $deviceAssignment = $this->repository->activeForDevice($device);

            if (
                $deviceAssignment !== null &&
                $deviceAssignment->vehicle_id !== $vehicle->id
            ) {
                throw new BusinessException(
                    title: 'Device Already Paired',
                    detail: 'This OBD device is already paired with another vehicle.',
                );
            }

            // Vehicle already has an active device.
            $vehicleAssignment = $this->repository->activeForVehicle($vehicle);

            if ($vehicleAssignment !== null) {
                $this->repository->update($vehicleAssignment, [
                    'is_active' => false,
                    'unpaired_at' => now(),
                ]);
            }

            /** @var VehicleObdDevice */
            return $this->repository->create([
                'vehicle_id' => $vehicle->id,
                'obd_device_id' => $device->id,
                'paired_at' => now(),
                'unpaired_at' => null,
                'is_active' => true,
                'notes' => $attributes['notes'] ?? null,
            ]);
        });
    }

    public function unpair(
        Vehicle $vehicle,
        ObdDevice $device,
        array $attributes = [],
    ): VehicleObdDevice {
        return DB::transaction(function () use (
            $vehicle,
            $device,
            $attributes,
        ): VehicleObdDevice {

            $pairing = $this->repository->activePairing(
                $vehicle,
                $device,
            );

            if ($pairing === null) {
                throw new BusinessException(
                    title: 'Device Already Paired',
                    detail: 'This OBD device is already paired with another vehicle.',
                );
            }

            /** @var VehicleObdDevice */
            return $this->repository->update($pairing, [
                'is_active' => false,
                'unpaired_at' => now(),
                'notes' => $attributes['notes'] ?? $pairing->notes,
            ]);
        });
    }

    public function current(
        Vehicle $vehicle,
    ): ?VehicleObdDevice {
        return $this->repository->activeForVehicle($vehicle);
    }

    public function history(
        Vehicle $vehicle,
    ): Collection {
        return $this->repository->history($vehicle);
    }
}
