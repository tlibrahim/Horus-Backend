<?php

namespace Modules\Core\Database\Seeders;

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
            ],
            [
                'group' => 'app',
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
                'description' => 'Default application language',
            ],
            [
                'group' => 'app',
                'key' => 'default_timezone',
                'value' => 'Africa/Cairo',
                'type' => 'string',
                'description' => 'Default timezone',
            ],

            // Mail
            [
                'group' => 'mail',
                'key' => 'support_email',
                'value' => 'support@horusdrive.com',
                'type' => 'string',
                'description' => 'Support email address',
            ],

            // Security
            [
                'group' => 'security',
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Enable maintenance mode',
            ],
            [
                'group' => 'security',
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Maximum login attempts',
            ],
            [
                'group' => 'security',
                'key' => 'lockout_minutes',
                'value' => '15',
                'type' => 'integer',
                'description' => 'Account lockout duration',
            ],

            // Uploads
            [
                'group' => 'uploads',
                'key' => 'max_upload_size',
                'value' => '10240',
                'type' => 'integer',
                'description' => 'Maximum upload size (KB)',
            ],
            [
                'group' => 'uploads',
                'key' => 'allowed_image_extensions',
                'value' => 'jpg,jpeg,png,webp',
                'type' => 'string',
                'description' => 'Allowed image extensions',
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
