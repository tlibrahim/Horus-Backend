<?php

namespace Modules\Core\Database\Seeders\Localization;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'US Dollar',
                'is_default' => false,
                'currency_symbol' => '$',
                'is_active' => true,
            ],
            [
                'code' => 'EGP',
                'symbol' => 'E£',
                'name' => 'Egyptian Pound',
                'is_default' => true,
                'currency_symbol' => '£',
                'is_active' => true,
            ],
            [
                'code' => 'SAR',
                'symbol' => 'SAR',
                'name' => 'Saudi Riyal',
                'is_default' => false,
                'currency_symbol' => '﷼',
                'is_active' => true,
            ],
            [
                'code' => 'AED',
                'symbol' => 'AED',
                'name' => 'UAE Dirham',
                'is_default' => false,
                'currency_symbol' => 'د.إ',
                'is_active' => true,
            ],
            [
                'code' => 'JPY',
                'symbol' => 'JPY',
                'name' => 'Japanese Yen',
                'is_default' => false,
                'currency_symbol' => '¥',
                'is_active' => true,
            ],
            [
                'code' => 'EUR',
                'symbol' => 'EUR',
                'name' => 'Euro',
                'is_default' => false,
                'currency_symbol' => '€',
                'is_active' => true,
            ],
            [
                'code' => 'KRW',
                'symbol' => 'KRW',
                'name' => 'South Korean Won',
                'is_default' => false,
                'currency_symbol' => '₩',
                'is_active' => true,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
