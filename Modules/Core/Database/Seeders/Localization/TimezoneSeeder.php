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
            [
                'name' => 'Asia/Tokyo',
                'utc_offset' => '+09:00',
                'is_active' => true,
            ],
            [
                'name' => 'America/New_York',
                'utc_offset' => '-05:00',
                'is_active' => true,
            ],
            [
                'name' => 'Europe/Berlin',
                'utc_offset' => '+01:00',
                'is_active' => true,
            ],
        ];

        foreach ($timezones as $timezone) {
            Timezone::updateOrCreate(
                ['name' => $timezone['name']],
                $timezone
            );
        }
    }
}
