<?php

declare(strict_types=1);

namespace Modules\IAM\Services\Auth;

use App\Support\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\IAM\Models\User;

final class RegisterService extends BaseService
{
    public function register(array $attributes): User
    {
        /** @var User $user */
        $user = $this->transaction(function () use ($attributes): User {
            /** @var User $created */
            $created = User::query()->create([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'display_name' => $attributes['display_name'] ?? trim($attributes['first_name'].' '.$attributes['last_name']),
                'mobile' => $attributes['mobile'],
                'email' => $attributes['email'] ?? null,
                'password' => Hash::make((string) $attributes['password']),
                'is_verified' => false,
                'is_active' => true,
            ]);

            return $created;
        });

        return $user;
    }
}
