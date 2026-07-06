<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Country;
use Modules\Core\Models\VehicleMake;

class VehicleMakeSeeder extends Seeder
{
    public function run(): void
    {
        $countriesByIso2 = Country::whereIn('iso2', ['EG', 'SA', 'AE'])
            ->pluck('id', 'iso2');

        $makes = [
            [
                'name' => 'Egypt Auto',
                'slug' => 'egypt-auto',
                'country_id' => $countriesByIso2['EG'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Saudi Motors',
                'slug' => 'saudi-motors',
                'country_id' => $countriesByIso2['SA'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Emirates Mobility',
                'slug' => 'emirates-mobility',
                'country_id' => $countriesByIso2['AE'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
        ];

        foreach ($makes as $make) {
            VehicleMake::updateOrCreate(
                ['name' => $make['name']],
                $make
            );
        }
    }
}
