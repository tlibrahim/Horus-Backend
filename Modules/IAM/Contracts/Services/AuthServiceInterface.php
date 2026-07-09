<?php

declare(strict_types=1);

namespace Modules\IAM\Contracts\Services;

use Modules\IAM\Models\User;

interface AuthServiceInterface
{
    public function register(array $attributes): array;

    public function verifyOtp(array $attributes): array;

    public function resendOtp(array $attributes): array;

    public function login(array $attributes): array;

    public function refresh(string $refreshToken): array;

    public function logout(User $user, ?string $refreshToken = null): void;

    public function logoutAll(User $user): void;

    public function forgotPassword(array $attributes): array;

    public function resetPassword(array $attributes): array;

    public function changePassword(User $user, array $attributes): array;
}
