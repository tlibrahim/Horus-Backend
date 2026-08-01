<?php

namespace Modules\Auth\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRoleName = (string) data_get(config('auth.admin'), 'role', 'Super Admin');

        $superAdmin = Role::query()
            ->where('name', $superAdminRoleName)
            ->first();

        if ($superAdmin === null) {
            return;
        }

        $superAdmin->permissions()->sync(
            Permission::query()->pluck('id')->all(),
        );

        foreach ((array) config('auth.role_permissions', []) as $roleName => $permissionCodes) {
            $role = Role::query()
                ->where('name', (string) $roleName)
                ->first();

            if ($role === null) {
                continue;
            }

            $permissionIds = Permission::query()
                ->whereIn('code', (array) $permissionCodes)
                ->pluck('id')
                ->all();

            $role->permissions()->sync($permissionIds);
        }
    }
}
