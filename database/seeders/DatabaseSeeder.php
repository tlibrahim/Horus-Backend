<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\IAM\Database\Seeders\IAMDatabaseSeeder;
use Modules\Vehicle\Database\Seeders\VehicleDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CoreDatabaseSeeder::class,
            IAMDatabaseSeeder::class,
            VehicleDatabaseSeeder::class,
        ]);
    }
}
