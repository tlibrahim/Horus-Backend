<?php

declare(strict_types=1);

namespace Modules\Auth\Contracts\Services;

use App\Support\Contracts\ActivatableServiceInterface;
use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Auth\Models\Role;

interface RoleServiceInterface extends ActivatableServiceInterface, CrudServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Role;

    public function create(array $attributes): Role;

    public function options(): Collection;

    public function syncPermissions(Role $role, array $permissionIds): Role;

    public function permissions(Role $role): Collection;
}
