<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\City;

interface CityServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): City;

    public function create(array $attributes): City;

    public function update(City $city, array $attributes): City;

    public function options(): Collection;

    public function toggleStatus(City $city, bool $isActive): City;

    public function delete(City $city): bool;
}
