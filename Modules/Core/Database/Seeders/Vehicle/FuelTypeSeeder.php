<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\FuelType;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $fuelTypes = [
            [
                'name' => 'Gasoline',
                'code' => 'GASOLINE',
                'discription' => 'Petrol-based fuel type.',
                'is_active' => true,
            ],
            [
                'name' => 'Diesel',
                'code' => 'DIESEL',
                'discription' => 'Diesel fuel type.',
                'is_active' => true,
            ],
            [
                'name' => 'Electric',
                'code' => 'ELECTRIC',
                'discription' => 'Battery electric power source.',
                'is_active' => true,
            ],
        ];

        foreach ($fuelTypes as $fuelType) {
            FuelType::updateOrCreate(
                ['code' => $fuelType['code']],
                $fuelType
            );
        }
    }
}
