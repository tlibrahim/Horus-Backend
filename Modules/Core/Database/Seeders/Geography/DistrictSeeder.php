<?php

namespace Modules\Core\Database\Seeders\Geography;

use Illuminate\Database\Seeder;
use Modules\Core\Models\District;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            [
                'city_id' => 1,
                'name' => 'Cairo',
                'latitude' => 30.0444,
                'longitude' => 31.2357,
            ],
            [
                'city_id' => 1,
                'name' => 'Giza',
                'latitude' => 29.9870,
                'longitude' => 31.2089,
            ],
            [
                'city_id' => 2,
                'name' => 'Riyadh',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
            ],
            [
                'city_id' => 2,
                'name' => 'Jeddah',
                'latitude' => 21.4858,
                'longitude' => 39.1925,
            ],
            [
                'city_id' => 3,
                'name' => 'Abu Dhabi',
                'latitude' => 24.4539,
                'longitude' => 54.3773,
            ],
            [
                'city_id' => 3,
                'name' => 'Dubai',
                'latitude' => 25.276987,
                'longitude' => 55.296249,
            ],

        ];

        foreach ($districts as $district) {
            District::updateOrCreate(
                ['name' => $district['name']],
                $district
            );
        }
    }
}
