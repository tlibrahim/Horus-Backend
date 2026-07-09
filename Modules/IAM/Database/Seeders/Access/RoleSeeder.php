<?php

namespace Modules\IAM\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\IAM\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('iam.roles', []) as $name) {
            $name = trim((string) $name);

            if ($name === '') {
                continue;
            }

            Role::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'description' => null,
                    'is_system' => true,
                    'is_active' => true,
                ],
            );
        }
    }
}
