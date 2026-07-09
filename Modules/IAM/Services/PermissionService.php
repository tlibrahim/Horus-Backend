<?php

declare(strict_types=1);

namespace Modules\IAM\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\IAM\Contracts\Repositories\PermissionRepositoryInterface;
use Modules\IAM\Contracts\Services\PermissionServiceInterface;
use Modules\IAM\Filters\PermissionFilter;
use Modules\IAM\Models\Permission;

final class PermissionService extends BaseCrudService implements PermissionServiceInterface
{
    public function __construct(
        private readonly PermissionRepositoryInterface $permissions,
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

    public function find(int|string $id): Permission
    {
        /** @var Permission */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Permission
    {
        /** @var Permission */
        return $this->createFromRepository($attributes);
    }

    public function update(Permission $permission, array $attributes): Permission
    {
        /** @var Permission */
        return $this->updateFromRepository($permission, $attributes);
    }

    public function delete(Permission $permission): bool
    {
        return $this->deleteFromRepository($permission);
    }

    protected function repository(): PermissionRepositoryInterface
    {
        return $this->permissions;
    }

    protected function filterClass(): ?string
    {
        return PermissionFilter::class;
    }
}
