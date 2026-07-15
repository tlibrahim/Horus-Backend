<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\Engine;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Engine;

interface EngineServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Engine;

    public function create(array $attributes): Engine;

    public function update(Engine $engine, array $attributes): Engine;

    public function options(): Collection;

    public function toggleStatus(Engine $engine, bool $isActive): Engine;

    public function delete(Engine $engine): bool;
}
