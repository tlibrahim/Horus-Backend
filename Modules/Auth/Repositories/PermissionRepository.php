<?php

declare(strict_types=1);

namespace Modules\Auth\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Auth\Contracts\Repositories\PermissionRepositoryInterface;
use Modules\Auth\Models\Permission;

final class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected function model(): string
    {
        return Permission::class;
    }
}
