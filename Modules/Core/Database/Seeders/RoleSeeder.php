<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Enums\Role as RoleEnum;
use Modules\Core\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::updateOrCreate(
                ['name' => $role->value],
                [
                    'guard_name' => 'api',
                    'display_name' => ucwords(str_replace('-', ' ', $role->value)),
                    'is_system' => true,
                ]
            );
        }
    }
}
