<?php

declare(strict_types=1);

namespace Modules\IAM\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\IAM\Contracts\Repositories\RoleRepositoryInterface;
use Modules\IAM\Contracts\Services\RoleServiceInterface;
use Modules\IAM\Filters\RoleFilter;
use Modules\IAM\Models\Role;

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

    public function update(Role $role, array $attributes): Role
    {
        /** @var Role */
        return $this->updateFromRepository($role, $attributes);
    }

    public function toggleStatus(Role $role, bool $isActive): Role
    {
        /** @var Role */
        return $this->toggleStatusOnRepository($role, $isActive);
    }

    public function activate(Role $role): Role
    {
        /** @var Role */
        return $this->activateOnRepository($role);
    }

    public function deactivate(Role $role): Role
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

    public function delete(Role $role): bool
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
