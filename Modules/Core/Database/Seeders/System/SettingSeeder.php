<?php

namespace Modules\Core\Database\Seeders\System;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            // Application
            [
                'group' => 'app',
                'key' => 'app_name',
                'value' => 'HorusDrive',
                'type' => 'string',
                'description' => 'Application name',
                'is_public' => true,
            ],
            [
                'group' => 'app',
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
                'description' => 'Default application language',
                'is_public' => true,
            ],
            [
                'group' => 'app',
                'key' => 'default_timezone',
                'value' => 'Africa/Cairo',
                'type' => 'string',
                'description' => 'Default timezone',
                'is_public' => true,
            ],

            // Mail
            [
                'group' => 'mail',
                'key' => 'support_email',
                'value' => 'support@horusdrive.com',
                'type' => 'string',
                'description' => 'Support email address',
                'is_public' => true,
            ],

            // Security
            [
                'group' => 'security',
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Enable maintenance mode',
                'is_public' => false,
            ],
            [
                'group' => 'security',
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Maximum login attempts',
                'is_public' => false,
            ],
            [
                'group' => 'security',
                'key' => 'lockout_minutes',
                'value' => '15',
                'type' => 'integer',
                'description' => 'Account lockout duration',
                'is_public' => false,
            ],

            // Uploads
            [
                'group' => 'uploads',
                'key' => 'max_upload_size',
                'value' => '10240',
                'type' => 'integer',
                'description' => 'Maximum upload size (KB)',
                'is_public' => false,
            ],
            [
                'group' => 'uploads',
                'key' => 'allowed_image_extensions',
                'value' => 'jpg,jpeg,png,webp',
                'type' => 'string',
                'description' => 'Allowed image extensions',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
