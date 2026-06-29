<?php

namespace Modules\Core\Database\Seeders\Localization;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Timezone;

class TimezoneSeeder extends Seeder
{
    public function run(): void
    {
        $timezones = [
            [
                'name' => 'UTC',
                'utc_offset' => '+00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Africa/Cairo',
                'utc_offset' => '+02:00',
                'is_active' => true,
            ],
            [
                'name' => 'Asia/Riyadh',
                'utc_offset' => '+03:00',
                'is_active' => true,
            ],
            [
                'name' => 'Asia/Dubai',
                'utc_offset' => '+04:00',
                'is_active' => true,
            ],
        ];

        foreach ($timezones as $timezone) {
            Timezone::updateOrCreate(
                ['utc_offset' => $timezone['utc_offset']],
                $timezone
            );
        }
    }
}
