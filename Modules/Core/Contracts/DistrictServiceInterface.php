<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\District;

interface DistrictServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): District;

    public function create(array $attributes): District;

    public function update(District $district, array $attributes): District;

    public function options(): Collection;

    public function toggleStatus(District $district, bool $isActive): District;

    public function delete(District $district): bool;
}
