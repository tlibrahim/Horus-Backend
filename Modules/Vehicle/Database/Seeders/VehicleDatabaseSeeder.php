<?php

namespace Modules\Vehicle\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Database\Seeders\Vehicle\BodyTypeSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\BrandSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\DriveTypeSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\EngineSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\FuelTypeSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\GenerationSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\ModelSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\TransmissionSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\VehicleDocumentTypeSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\VehicleSeeder;
use Modules\Vehicle\Database\Seeders\Vehicle\VehicleTypeSeeder;

class VehicleDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FuelTypeSeeder::class,
            TransmissionSeeder::class,
            DriveTypeSeeder::class,
            BodyTypeSeeder::class,
            VehicleTypeSeeder::class,
            BrandSeeder::class,
            ModelSeeder::class,
            GenerationSeeder::class,
            EngineSeeder::class,
            VehicleSeeder::class,
            VehicleDocumentTypeSeeder::class,
        ]);
    }
}
