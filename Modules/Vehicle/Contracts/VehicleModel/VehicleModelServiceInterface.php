<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleModel;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\VehicleModel;

interface VehicleModelServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): VehicleModel;

    public function create(array $attributes): VehicleModel;

    public function update(VehicleModel $vehicleModel, array $attributes): VehicleModel;

    public function options(): Collection;

    public function toggleStatus(VehicleModel $vehicleModel, bool $isActive): VehicleModel;

    public function delete(VehicleModel $vehicleModel): bool;
}
