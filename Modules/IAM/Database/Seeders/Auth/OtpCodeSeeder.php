<?php

namespace Modules\IAM\Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\IAM\Models\OtpCode;
use Modules\IAM\Models\User;

class OtpCodeSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'mobile' => '+201000000001',
                'code' => '123456',
                'purpose' => 'login',
                'expires_at' => now()->addMinutes(10),
                'verified_at' => now(),
                'attempts' => 1,
            ],
            [
                'mobile' => '+201000000002',
                'code' => '654321',
                'purpose' => 'register',
                'expires_at' => now()->addMinutes(10),
                'verified_at' => null,
                'attempts' => 0,
            ],
        ];

        foreach ($records as $record) {
            $userId = User::query()->where('mobile', $record['mobile'])->value('id');

            OtpCode::updateOrCreate(
                [
                    'mobile' => $record['mobile'],
                    'purpose' => $record['purpose'],
                ],
                [
                    'user_id' => $userId,
                    'code_hash' => Hash::make((string) $record['code']),
                    'expires_at' => $record['expires_at'],
                    'verified_at' => $record['verified_at'],
                    'attempts' => $record['attempts'],
                ],
            );
        }
    }
}
