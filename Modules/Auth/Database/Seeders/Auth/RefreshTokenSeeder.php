<?php

namespace Modules\Auth\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\RefreshToken;
use Modules\Auth\Models\User;
use Modules\Auth\Support\RefreshTokenManager;

class RefreshTokenSeeder extends Seeder
{
    public function run(): void
    {
        $refreshTokenManager = app(RefreshTokenManager::class);

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

            RefreshToken::updateOrCreate(
                ['token_hash' => $refreshTokenManager->hash((string) $item['token'])],
                [
                    'user_id' => $userId,
                    'user_session_id' => null,
                    'expires_at' => $item['expires_at'],
                    'revoked_at' => null,
                ],
            );
        }
    }
}
