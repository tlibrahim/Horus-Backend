<?php

namespace Modules\IAM\Database\Seeders\User;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\Role;
use Modules\IAM\Models\User;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::query()->where('slug', 'admin')->value('id');
        $userRoleId = Role::query()->where('slug', 'user')->value('id');

        $admin = User::query()->where('mobile', '+201000000001')->first();
        $user = User::query()->where('mobile', '+201000000002')->first();

        if ($admin !== null && $adminRoleId !== null) {
            $admin->roles()->syncWithoutDetaching([$adminRoleId]);
        }

        if ($user !== null && $userRoleId !== null) {
            $user->roles()->syncWithoutDetaching([$userRoleId]);
        }
    }
}
