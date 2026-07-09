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
        $englishLanguageId = Language::where('code', 'en')->value('id');

        $currenciesByCode = Currency::whereIn('code', ['EGP', 'SAR', 'AED', 'USD', 'JPY', 'EUR', 'KRW'])
            ->pluck('id', 'code');

        $timezonesByName = Timezone::whereIn('name', ['Africa/Cairo', 'Asia/Riyadh', 'Asia/Dubai', 'Asia/Tokyo', 'America/New_York', 'Europe/Berlin'])
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
            [
                'name' => 'Japan',
                'iso2' => 'JP',
                'iso3' => 'JPN',
                'phone_code' => '81',
                'currency_id' => $currenciesByCode['JPY'] ?? null,
                'language_id' => $englishLanguageId,
                'timezone_id' => $timezonesByName['Asia/Tokyo'] ?? null,
                'nationality' => 'Japanese',
            ],
            [
                'name' => 'United States',
                'iso2' => 'US',
                'iso3' => 'USA',
                'phone_code' => '1',
                'currency_id' => $currenciesByCode['USD'] ?? null,
                'language_id' => $englishLanguageId,
                'timezone_id' => $timezonesByName['America/New_York'] ?? null,
                'nationality' => 'American',
            ],
            [
                'name' => 'Germany',
                'iso2' => 'DE',
                'iso3' => 'DEU',
                'phone_code' => '49',
                'currency_id' => $currenciesByCode['EUR'] ?? null,
                'language_id' => $englishLanguageId,
                'timezone_id' => $timezonesByName['Europe/Berlin'] ?? null,
                'nationality' => 'German',
            ],
            [
                'name' => 'South Korea',
                'iso2' => 'KR',
                'iso3' => 'KOR',
                'phone_code' => '82',
                'currency_id' => $currenciesByCode['KRW'] ?? null,
                'language_id' => $englishLanguageId,
                'timezone_id' => $timezonesByName['Asia/Tokyo'] ?? null,
                'nationality' => 'Korean',
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
