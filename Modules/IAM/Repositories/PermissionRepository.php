<?php

declare(strict_types=1);

namespace Modules\IAM\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\IAM\Contracts\Repositories\PermissionRepositoryInterface;
use Modules\IAM\Models\Permission;

final class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected function model(): string
    {
        return Permission::class;
    }
}
