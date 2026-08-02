<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\Vehicle;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Vehicle\Models\Vehicle;

interface VehicleServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Vehicle;

    public function create(array $attributes): Vehicle;

    public function update(Model $vehicle, array $attributes): Model;

    public function options(): Collection;

    public function toggleStatus(Model $vehicle, bool $isActive): Model;

    public function delete(Model $vehicle): bool;
}
