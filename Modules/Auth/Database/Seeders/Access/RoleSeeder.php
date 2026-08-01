<?php

namespace Modules\Auth\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Auth\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('auth.roles', []) as $role) {
            $role = is_array($role)
                ? $role
                : ['name' => (string) $role];

            $name = trim((string) data_get($role, 'name', ''));

            if ($name === '') {
                continue;
            }

            $slug = trim((string) data_get($role, 'slug', ''));

            Role::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => $slug !== '' ? $slug : Str::slug($name),
                    'description' => data_get($role, 'description'),
                    'is_system' => (bool) data_get($role, 'is_system', true),
                    'is_active' => (bool) data_get($role, 'is_active', true),
                ],
            );
        }
    }
}
