<?php

namespace Modules\IAM\Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\IAM\Models\Role;
use Modules\IAM\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        /** @var array{name:string,email:string,password:string,mobile:string,role:string} $config */
        $config = config('iam.admin', []);

        if ($config === []) {
            return;
        }

        $fullName = trim((string) ($config['name'] ?? 'Super Admin'));
        $nameParts = preg_split('/\s+/', $fullName) ?: [];

        $firstName = $nameParts[0] ?? 'Super';
        $lastName = isset($nameParts[1])
            ? implode(' ', array_slice($nameParts, 1))
            : 'Admin';

        $email = $config['email'] ?? null;

        /** @var User $user */
        $user = User::updateOrCreate(
            [
                'email' => $email,
            ],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'display_name' => $fullName,
                'mobile' => $config['mobile'] ?? '+201000000000',
                'password' => Hash::make((string) ($config['password'] ?? 'Admin@123456')),
                'is_active' => true,
                'is_verified' => true,
                'email_verified_at' => now(),
            ],
        );

        $roleName = (string) ($config['role'] ?? 'Super Admin');
        $roleId = Role::query()->where('name', $roleName)->value('id');

        if ($roleId !== null) {
            $user->roles()->sync([$roleId]);
        }
    }
}
