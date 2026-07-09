<?php

namespace Modules\IAM\Database\Seeders\User;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserProfile;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'mobile' => '+201000000001',
                'date_of_birth' => '1990-01-01',
                'gender' => 'male',
                'nationality' => 'Egyptian',
                'job_title' => 'Administrator',
            ],
            [
                'mobile' => '+201000000002',
                'date_of_birth' => '1995-05-10',
                'gender' => 'female',
                'nationality' => 'Egyptian',
                'job_title' => 'Customer',
            ],
        ];

        foreach ($profiles as $profile) {
            $userId = User::query()->where('mobile', $profile['mobile'])->value('id');

            if ($userId === null) {
                continue;
            }

            UserProfile::updateOrCreate(
                ['user_id' => $userId],
                [
                    'date_of_birth' => $profile['date_of_birth'],
                    'gender' => $profile['gender'],
                    'nationality' => $profile['nationality'],
                    'job_title' => $profile['job_title'],
                ],
            );
        }
    }
}
