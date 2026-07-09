<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Passenger', 'Commercial', 'Truck', 'Motorcycle', 'Bus'] as $name) {
            VehicleType::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ],
            );
        }
    }
}
