<?php

namespace Modules\IAM\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\RefreshToken;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserDevice;

class RefreshTokenSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = [
            [
                'mobile' => '+201000000001',
                'token' => 'cccccccc-cccc-cccc-cccc-cccccccccccc',
                'expires_at' => now()->addDays(30),
            ],
            [
                'mobile' => '+201000000002',
                'token' => 'dddddddd-dddd-dddd-dddd-dddddddddddd',
                'expires_at' => now()->addDays(30),
            ],
        ];

        foreach ($tokens as $item) {
            $userId = User::query()->where('mobile', $item['mobile'])->value('id');

            if ($userId === null) {
                continue;
            }

            $deviceId = UserDevice::query()->where('user_id', $userId)->value('id');

            RefreshToken::updateOrCreate(
                ['token' => $item['token']],
                [
                    'user_id' => $userId,
                    'user_device_id' => $deviceId,
                    'expires_at' => $item['expires_at'],
                    'revoked_at' => null,
                ],
            );
        }
    }
}
