<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Enums\Permission as PermissionEnum;
use Modules\Core\Enums\Role as RoleEnum;
use Modules\Core\Models\Permission;
use Modules\Core\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach (PermissionEnum::cases() as $permission) {

            Permission::updateOrCreate(
                [
                    'name' => $permission->value,
                ],
                [
                    'guard_name' => 'api',
                    'display_name' => ucwords(str_replace(['.', '_'], ' ', $permission->value)),
                    'description' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Give Super Admin All Permissions
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::where('name', RoleEnum::SUPER_ADMIN->value)->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }
    }
}
