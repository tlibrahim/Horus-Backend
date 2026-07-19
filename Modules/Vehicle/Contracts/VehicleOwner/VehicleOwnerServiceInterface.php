<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleOwner;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;

interface VehicleOwnerServiceInterface
{
    public function all(): iterable;

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator;

    public function options(): Collection;

    public function find(
        int|string $id,
    ): VehicleOwner;

    public function create(
        Vehicle $vehicle,
        array $attributes,
    ): VehicleOwner;

    public function update(
        VehicleOwner $ownership,
        array $attributes,
    ): VehicleOwner;

    public function delete(
        VehicleOwner $ownership,
    ): bool;

    public function byVehicle(
        Vehicle $vehicle,
    ): Collection;

    public function primary(
        Vehicle $vehicle,
    ): ?VehicleOwner;

    public function active(
        Vehicle $vehicle,
    ): Collection;
}
