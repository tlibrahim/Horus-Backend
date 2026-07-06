<?php

namespace Modules\Core\Database\Seeders\Geography;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Country;
use Modules\Core\Models\Currency;
use Modules\Core\Models\Language;
use Modules\Core\Models\Timezone;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $arabicLanguageId = Language::where('code', 'ar')->value('id');

        $currenciesByCode = Currency::whereIn('code', ['EGP', 'SAR', 'AED'])
            ->pluck('id', 'code');

        $timezonesByName = Timezone::whereIn('name', ['Africa/Cairo', 'Asia/Riyadh', 'Asia/Dubai'])
            ->pluck('id', 'name');

        $countries = [
            [
                'name' => 'Egypt',
                'iso2' => 'EG',
                'iso3' => 'EGY',
                'phone_code' => '20',
                'currency_id' => $currenciesByCode['EGP'] ?? null,
                'language_id' => $arabicLanguageId,
                'timezone_id' => $timezonesByName['Africa/Cairo'] ?? null,
                'nationality' => 'Egyptian',
            ],
            [
                'name' => 'Saudi Arabia',
                'iso2' => 'SA',
                'iso3' => 'SAU',
                'phone_code' => '966',
                'currency_id' => $currenciesByCode['SAR'] ?? null,
                'language_id' => $arabicLanguageId,
                'timezone_id' => $timezonesByName['Asia/Riyadh'] ?? null,
                'nationality' => 'Saudi',
            ],
            [
                'name' => 'United Arab Emirates',
                'iso2' => 'AE',
                'iso3' => 'ARE',
                'phone_code' => '971',
                'currency_id' => $currenciesByCode['AED'] ?? null,
                'language_id' => $arabicLanguageId,
                'timezone_id' => $timezonesByName['Asia/Dubai'] ?? null,
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
