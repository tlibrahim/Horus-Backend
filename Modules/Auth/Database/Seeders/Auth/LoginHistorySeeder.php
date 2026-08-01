<?php

namespace Modules\Auth\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\LoginHistory;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserDevice;

class LoginHistorySeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'mobile' => '+201000000001',
                'ip_address' => '192.168.1.10',
                'platform' => 'ios',
                'is_success' => true,
                'failure_reason' => null,
                'logged_in_at' => now()->subDay(),
            ],
            [
                'mobile' => '+201000000002',
                'ip_address' => '192.168.1.11',
                'platform' => 'android',
                'is_success' => false,
                'failure_reason' => 'Invalid OTP',
                'logged_in_at' => now()->subHours(5),
            ],
        ];

        foreach ($records as $record) {
            $userId = User::query()->where('mobile', $record['mobile'])->value('id');

            if ($userId === null) {
                continue;
            }

            $deviceId = UserDevice::query()->where('user_id', $userId)->value('id');

            LoginHistory::updateOrCreate(
                [
                    'user_id' => $userId,
                    'logged_in_at' => $record['logged_in_at'],
                ],
                [
                    'user_device_id' => $deviceId,
                    'ip_address' => $record['ip_address'],
                    'platform' => $record['platform'],
                    'is_success' => $record['is_success'],
                    'failure_reason' => $record['failure_reason'],
                ],
            );
        }
    }
}
