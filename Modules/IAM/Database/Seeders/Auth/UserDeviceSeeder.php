<?php

namespace Modules\IAM\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserDevice;

class UserDeviceSeeder extends Seeder
{
    public function run(): void
    {
        $devices = [
            [
                'mobile' => '+201000000001',
                'device_uuid' => 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
                'platform' => 'ios',
                'device_name' => 'iPhone 15 Pro',
                'os_version' => '17.5',
                'app_version' => '1.0.0',
                'firebase_token' => 'firebase-token-admin',
                'is_active' => true,
            ],
            [
                'mobile' => '+201000000002',
                'device_uuid' => 'bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb',
                'platform' => 'android',
                'device_name' => 'Pixel 8',
                'os_version' => '14',
                'app_version' => '1.0.0',
                'firebase_token' => 'firebase-token-user',
                'is_active' => true,
            ],
        ];

        foreach ($devices as $device) {
            $userId = User::query()->where('mobile', $device['mobile'])->value('id');

            if ($userId === null) {
                continue;
            }

            UserDevice::updateOrCreate(
                ['user_id' => $userId, 'device_uuid' => $device['device_uuid']],
                [
                    'platform' => $device['platform'],
                    'device_name' => $device['device_name'],
                    'os_version' => $device['os_version'],
                    'app_version' => $device['app_version'],
                    'firebase_token' => $device['firebase_token'],
                    'last_login_at' => now()->subDay(),
                    'is_active' => $device['is_active'],
                ],
            );
        }
    }
}
