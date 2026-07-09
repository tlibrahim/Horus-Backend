<?php

declare(strict_types=1);

namespace Modules\IAM\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\IAM\Models\Role;

interface RoleServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Role;

    public function create(array $attributes): Role;

    public function update(Role $role, array $attributes): Role;

    public function options(): Collection;

    public function toggleStatus(Role $role, bool $isActive): Role;

    public function activate(Role $role): Role;

    public function deactivate(Role $role): Role;

    public function syncPermissions(Role $role, array $permissionIds): Role;

    public function permissions(Role $role): Collection;

    public function delete(Role $role): bool;
}
