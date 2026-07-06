<?php

namespace Modules\Core\Database\Seeders\System;

use Illuminate\Database\Seeder;
use Modules\Core\Models\FeatureFlag;

class FeatureFlagSeeder extends Seeder
{
    public function run(): void
    {
        $featureFlags = [
            [
                'key' => 'booking_enabled',
                'enabled' => true,
                'description' => 'Enable booking flows across the application.',
            ],
            [
                'key' => 'workshop_reviews_enabled',
                'enabled' => true,
                'description' => 'Allow customers to leave workshop reviews.',
            ],
            [
                'key' => 'ai_assistant_enabled',
                'enabled' => false,
                'description' => 'Enable AI assistant features.',
            ],
        ];

        foreach ($featureFlags as $featureFlag) {
            FeatureFlag::updateOrCreate(
                ['key' => $featureFlag['key']],
                $featureFlag
            );
        }
    }
}
