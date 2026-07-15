<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Vehicle;

interface VehicleServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Vehicle;

    public function create(array $attributes): Vehicle;

    public function update(Vehicle $vehicle, array $attributes): Vehicle;

    public function options(): Collection;

    public function toggleStatus(Vehicle $vehicle, bool $isActive): Vehicle;

    public function delete(Vehicle $vehicle): bool;
}
