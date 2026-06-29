<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\Geography\CitySeeder;
use Modules\Core\Database\Seeders\Geography\CountrySeeder;
use Modules\Core\Database\Seeders\Geography\DistrictSeeder;
use Modules\Core\Database\Seeders\Localization\CurrencySeeder;
use Modules\Core\Database\Seeders\Localization\LanguageSeeder;
use Modules\Core\Database\Seeders\Localization\TimezoneSeeder;
use Modules\Core\Database\Seeders\Shared\ActivityLogSeeder;
use Modules\Core\Database\Seeders\Shared\AuditLogSeeder;
use Modules\Core\Database\Seeders\Shared\CacheSeeder;
use Modules\Core\Database\Seeders\Shared\FailedJobSeeder;
use Modules\Core\Database\Seeders\Shared\JobSeeder;
use Modules\Core\Database\Seeders\Shared\MediaSeeder;
use Modules\Core\Database\Seeders\Shared\NotificationSeeder;
use Modules\Core\Database\Seeders\Shared\PersonalAccessTokenSeeder;
use Modules\Core\Database\Seeders\Shared\SessionSeeder;
use Modules\Core\Database\Seeders\System\FeatureFlagSeeder;
use Modules\Core\Database\Seeders\System\SettingSeeder;

class CoreDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            TimezoneSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            MediaSeeder::class,
            AuditLogSeeder::class,
            ActivityLogSeeder::class,
            FailedJobSeeder::class,
            JobSeeder::class,
            NotificationSeeder::class,
            PersonalAccessTokenSeeder::class,
            CacheSeeder::class,
            SessionSeeder::class,
            SettingSeeder::class,
            FeatureFlagSeeder::class,
        ]);
    }
}
