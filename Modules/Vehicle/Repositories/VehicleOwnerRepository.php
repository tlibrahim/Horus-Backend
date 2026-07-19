<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\VehicleOwner\VehicleOwnerRepositoryInterface;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;

final class VehicleOwnerRepository extends BaseRepository implements VehicleOwnerRepositoryInterface
{
    protected function model(): string
    {
        return VehicleOwner::class;
    }

    public function byVehicle(
        Vehicle $vehicle,
    ): Collection {
        return VehicleOwner::query()
            ->where('vehicle_id', $vehicle->id)
            ->latest('started_at')
            ->get();
    }

    public function primary(
        Vehicle $vehicle,
    ): ?VehicleOwner {
        return VehicleOwner::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('is_primary', true)
            ->whereNull('ended_at')
            ->first();
    }

    public function active(
        Vehicle $vehicle,
    ): Collection {
        return VehicleOwner::query()
            ->where('vehicle_id', $vehicle->id)
            ->whereNull('ended_at')
            ->orderByDesc('is_primary')
            ->orderBy('started_at')
            ->get();
    }
}
