<?php

namespace Modules\IAM\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('iam.permissions', []) as $module => $resources) {
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
