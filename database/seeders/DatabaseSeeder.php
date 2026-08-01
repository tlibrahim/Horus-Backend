<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\OBD\Database\Seeders\OBDDatabaseSeeder;
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
            AuthDatabaseSeeder::class,
            VehicleDatabaseSeeder::class,
            OBDDatabaseSeeder::class,
        ]);
    }
}
