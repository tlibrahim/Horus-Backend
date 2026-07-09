<?php

declare(strict_types=1);

namespace Modules\IAM\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\IAM\Contracts\Repositories\RoleRepositoryInterface;
use Modules\IAM\Models\Role;

final class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected function model(): string
    {
        return Role::class;
    }
}
