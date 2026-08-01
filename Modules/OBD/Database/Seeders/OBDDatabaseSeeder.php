<?php

declare(strict_types=1);

namespace Modules\OBD\Database\Seeders;

use Illuminate\Database\Seeder;

final class OBDDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ObdDeviceSeeder::class,
            VehicleObdDeviceSeeder::class,
            ObdSessionSeeder::class,
        ]);
    }
}
