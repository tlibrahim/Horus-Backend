<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Egypt',
                'iso2' => 'EG',
                'iso3' => 'EGY',
                'phone_code' => '20',
                'currency_name' => 'EGP',
                'currency_symbol' => '£',
                'nationality' => 'Egyptian',
            ],
            [
                'name' => 'Saudi Arabia',
                'iso2' => 'SA',
                'iso3' => 'SAU',
                'phone_code' => '966',
                'currency_name' => 'SAR',
                'currency_symbol' => '﷼',
                'nationality' => 'Saudi',
            ],
            [
                'name' => 'United Arab Emirates',
                'iso2' => 'AE',
                'iso3' => 'ARE',
                'phone_code' => '971',
                'currency_name' => 'AED',
                'currency_symbol' => 'د.إ',
                'nationality' => 'Emirati',
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso2' => $country['iso2']],
                $country
            );
        }
    }
}
