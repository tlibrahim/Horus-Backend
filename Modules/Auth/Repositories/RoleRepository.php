<?php

declare(strict_types=1);

namespace Modules\Auth\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Auth\Contracts\Repositories\RoleRepositoryInterface;
use Modules\Auth\Models\Role;

final class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected function model(): string
    {
        return Role::class;
    }
}
