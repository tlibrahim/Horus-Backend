<?php

namespace Modules\IAM\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\Permission;
use Modules\IAM\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRoleName = (string) data_get(config('iam.admin'), 'role', 'Super Admin');

        $superAdmin = Role::query()
            ->where('name', $superAdminRoleName)
            ->first();

        if ($superAdmin === null) {
            return;
        }

        $superAdmin->permissions()->sync(
            Permission::query()->pluck('id')->all(),
        );

        foreach ((array) config('iam.role_permissions', []) as $roleName => $permissionCodes) {
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
