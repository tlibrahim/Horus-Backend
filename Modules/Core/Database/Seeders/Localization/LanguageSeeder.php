<?php

namespace Modules\Core\Database\Seeders\Localization;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'direction' => 'ltr',
                'is_default' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'direction' => 'rtl',
                'is_default' => false,
                'is_active' => true,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
