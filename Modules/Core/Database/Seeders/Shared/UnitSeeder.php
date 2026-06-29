<?php

namespace Modules\Core\Database\Seeders\Shared;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'name' => 'Kilometer',
                'symbol' => 'km',
                'type' => 'distance',
                'description' => 'Distance measurement in kilometers.',
                'is_active' => true,
            ],
            [
                'name' => 'Meter',
                'symbol' => 'm',
                'type' => 'distance',
                'description' => 'Distance measurement in meters.',
                'is_active' => true,
            ],
            [
                'name' => 'Liter',
                'symbol' => 'L',
                'type' => 'volume',
                'description' => 'Volume measurement in liters.',
                'is_active' => true,
            ],
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'type' => 'weight',
                'description' => 'Weight measurement in kilograms.',
                'is_active' => true,
            ],
            [
                'name' => 'Hour',
                'symbol' => 'h',
                'type' => 'time',
                'description' => 'Time measurement in hours.',
                'is_active' => true,
            ],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(
                ['symbol' => $unit['symbol']],
                $unit
            );
        }
    }
}
