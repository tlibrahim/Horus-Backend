<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Contracts\Repositories\RoleRepositoryInterface;
use Modules\Auth\Contracts\Services\RoleServiceInterface;
use Modules\Auth\Filters\RoleFilter;
use Modules\Auth\Models\Role;

final class RoleService extends BaseCrudService implements RoleServiceInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $roles,
    ) {}

    public function all(): Collection
    {
        return $this->allFromRepository();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(int|string $id): Role
    {
        /** @var Role */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Role
    {
        /** @var Role */
        return $this->createFromRepository($attributes);
    }

    public function update(Model $role, array $attributes): Model
    {
        /** @var Role */
        return $this->updateFromRepository($role, $attributes);
    }

    public function toggleStatus(Model $role, bool $isActive): Model
    {
        /** @var Role */
        return $this->toggleStatusOnRepository($role, $isActive);
    }

    public function activate(Model $role): Model
    {
        /** @var Role */
        return $this->activateOnRepository($role);
    }

    public function deactivate(Model $role): Model
    {
        /** @var Role */
        return $this->deactivateOnRepository($role);
    }

    public function syncPermissions(Role $role, array $permissionIds): Role
    {
        return $this->transaction(function () use ($role, $permissionIds): Role {
            $role->permissions()->sync($permissionIds);

            return $role->refresh();
        });
    }

    public function permissions(Role $role): Collection
    {
        return $role->permissions()->get();
    }

    public function delete(Model $role): bool
    {
        return $this->deleteFromRepository($role);
    }

    protected function repository(): RoleRepositoryInterface
    {
        return $this->roles;
    }

    protected function filterClass(): ?string
    {
        return RoleFilter::class;
    }
}
