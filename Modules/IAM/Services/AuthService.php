<?php

declare(strict_types=1);

namespace Modules\IAM\Services;

use App\Support\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\IAM\Contracts\Services\AuthServiceInterface;
use Modules\IAM\Models\User;
use Modules\IAM\Services\Auth\OtpService;
use Modules\IAM\Services\Auth\PasswordService;
use Modules\IAM\Services\Auth\RegisterService;
use Modules\IAM\Services\Auth\TokenService;
use Modules\IAM\Support\ThrowsAuthExceptions;

final class AuthService extends BaseService implements AuthServiceInterface
{
    use ThrowsAuthExceptions;

    public function __construct(
        private readonly RegisterService $registerService,
        private readonly OtpService $otpService,
        private readonly TokenService $tokenService,
        private readonly PasswordService $passwordService,
    ) {}

    public function register(array $attributes): array
    {
        $user = $this->registerService->register($attributes);

        $otp = $this->otpService->issue(
            mobile: $user->mobile,
            purpose: 'register',
            userId: (int) $user->id,
        );

        return [
            'user' => $user,
            'otp_sent' => true,
            'expires_at' => $otp->expires_at,
        ];
    }

    public function verifyOtp(array $attributes): array
    {
        $this->otpService->verify(
            mobile: (string) $attributes['mobile'],
            purpose: (string) $attributes['purpose'],
            plainCode: (string) $attributes['code'],
        );

        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        $this->transaction(function () use ($user, $attributes): void {
            if ($user !== null && $attributes['purpose'] === 'register') {
                $user->update([
                    'is_verified' => true,
                    'mobile_verified_at' => now(),
                ]);
            }
        });

        return [
            'verified' => true,
            'purpose' => $attributes['purpose'],
            'mobile' => $attributes['mobile'],
            'user' => $user,
        ];
    }

    public function resendOtp(array $attributes): array
    {
        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        $otp = $this->otpService->issue(
            mobile: (string) $attributes['mobile'],
            purpose: (string) $attributes['purpose'],
            userId: $user?->id,
        );

        return [
            'otp_sent' => true,
            'expires_at' => $otp->expires_at,
            'mobile' => $attributes['mobile'],
            'purpose' => $attributes['purpose'],
        ];
    }

    public function login(array $attributes): array
    {
        $login = (string) $attributes['login'];

        $user = User::query()
            ->where('mobile', $login)
            ->orWhere('email', $login)
            ->first();

        if ($user === null || ! Hash::check((string) $attributes['password'], (string) $user->password)) {
            $this->unauthorized('Invalid credentials.');
        }

        if (! $user->is_active) {
            $this->forbidden('User account is inactive.');
        }

        if (! $user->is_verified) {
            $this->forbidden('User account is not verified yet.');
        }

        return $this->tokenService->issueForLogin($user, $attributes);
    }

    public function refresh(string $refreshToken): array
    {
        return $this->tokenService->refresh($refreshToken);
    }

    public function logout(User $user, ?string $refreshToken = null): void
    {
        $this->tokenService->logout($user, $refreshToken);
    }

    public function logoutAll(User $user): void
    {
        $this->tokenService->logoutAll($user);
    }

    public function forgotPassword(array $attributes): array
    {
        return $this->passwordService->forgotPassword($attributes);
    }

    public function resetPassword(array $attributes): array
    {
        return $this->passwordService->resetPassword($attributes);
    }

    public function changePassword(User $user, array $attributes): array
    {
        return $this->passwordService->changePassword($user, $attributes);
    }
}
