<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;

class CoreDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            SettingSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
