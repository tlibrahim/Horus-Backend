<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Enums\Role as RoleEnum;
use Modules\Core\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@horusdrive.com',
            ],
            [
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'phone' => '200000000000',
                'password' => Hash::make('Admin@123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);
    }
}
