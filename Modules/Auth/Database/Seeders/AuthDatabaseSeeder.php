<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\Access\PermissionSeeder;
use Modules\Auth\Database\Seeders\Access\RolePermissionSeeder;
use Modules\Auth\Database\Seeders\Access\RoleSeeder;
use Modules\Auth\Database\Seeders\User\AdminUserSeeder;

class AuthDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
