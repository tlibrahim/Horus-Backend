<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\FuelType;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Gasoline', 'Diesel', 'Hybrid', 'Electric', 'Hydrogen'] as $name) {
            FuelType::updateOrCreate(
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
