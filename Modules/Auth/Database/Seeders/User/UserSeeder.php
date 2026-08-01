<?php

namespace Modules\Auth\Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;
use Modules\Core\Models\Country;
use Modules\Core\Models\Language;
use Modules\Core\Models\Timezone;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $countryId = Country::query()->where('iso2', 'EG')->value('id')
            ?? Country::query()->value('id');

        $languageId = Language::query()->where('code', 'en')->value('id')
            ?? Language::query()->value('id');

        $timezoneId = Timezone::query()->where('name', 'Africa/Cairo')->value('id')
            ?? Timezone::query()->value('id');

        $users = [
            [
                'uuid' => '11111111-1111-1111-1111-111111111111',
                'first_name' => 'System',
                'last_name' => 'Admin',
                'display_name' => 'System Admin',
                'email' => 'admin@horus.test',
                'mobile' => '+201000000001',
                'password' => Hash::make('password'),
                'country_id' => $countryId,
                'language_id' => $languageId,
                'timezone_id' => $timezoneId,
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),
            ],
            [
                'uuid' => '22222222-2222-2222-2222-222222222222',
                'first_name' => 'Default',
                'last_name' => 'User',
                'display_name' => 'Default User',
                'email' => 'user@horus.test',
                'mobile' => '+201000000002',
                'password' => Hash::make('password'),
                'country_id' => $countryId,
                'language_id' => $languageId,
                'timezone_id' => $timezoneId,
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['mobile' => $user['mobile']],
                $user,
            );
        }
    }
}
