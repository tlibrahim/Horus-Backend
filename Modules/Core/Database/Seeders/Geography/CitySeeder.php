<?php

namespace Modules\Core\Database\Seeders\Geography;

use Illuminate\Database\Seeder;
use Modules\Core\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'country_id' => 1,
                'name' => 'Cairo',
                'latitude' => 30.0444,
                'longitude' => 31.2357,
            ],
            [
                'country_id' => 1,
                'name' => 'Giza',
                'latitude' => 29.9870,
                'longitude' => 31.2089,
            ],
            [
                'country_id' => 2,
                'name' => 'Riyadh',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
            ],
            [
                'country_id' => 2,
                'name' => 'Jeddah',
                'latitude' => 21.4858,
                'longitude' => 39.1925,
            ],
            [
                'country_id' => 3,
                'name' => 'Abu Dhabi',
                'latitude' => 24.4539,
                'longitude' => 54.3773,
            ],
            [
                'country_id' => 3,
                'name' => 'Dubai',
                'latitude' => 25.276987,
                'longitude' => 55.296249,
            ],

        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['name' => $city['name']],
                $city
            );
        }
    }
}
