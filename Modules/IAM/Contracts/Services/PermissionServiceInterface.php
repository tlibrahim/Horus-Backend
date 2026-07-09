<?php

declare(strict_types=1);

namespace Modules\IAM\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\IAM\Models\Permission;

interface PermissionServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Permission;

    public function create(array $attributes): Permission;

    public function update(Permission $permission, array $attributes): Permission;

    public function options(): Collection;

    public function delete(Permission $permission): bool;
}
