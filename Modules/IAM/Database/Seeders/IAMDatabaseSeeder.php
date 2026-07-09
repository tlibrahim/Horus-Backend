<?php

namespace Modules\IAM\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\IAM\Database\Seeders\Access\PermissionSeeder;
use Modules\IAM\Database\Seeders\Access\RolePermissionSeeder;
use Modules\IAM\Database\Seeders\Access\RoleSeeder;
use Modules\IAM\Database\Seeders\User\AdminUserSeeder;

class IAMDatabaseSeeder extends Seeder
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
