<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\Brand;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Brand;

interface BrandServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Brand;

    public function create(array $attributes): Brand;

    public function update(Brand $brand, array $attributes): Brand;

    public function options(): Collection;

    public function toggleStatus(Brand $brand, bool $isActive): Brand;

    public function delete(Brand $brand): bool;
}
