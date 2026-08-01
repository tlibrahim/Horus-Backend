<?php

namespace Modules\Auth\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('auth.permissions', []) as $module => $resources) {
            foreach ($resources as $resource => $actions) {
                foreach ((array) $actions as $action) {
                    $code = "{$module}.{$resource}.{$action}";

                    Permission::updateOrCreate(
                        ['code' => $code],
                        [
                            'name' => $code,
                            'group' => (string) $module,
                            'description' => null,
                        ],
                    );
                }
            }
        }
    }
}
