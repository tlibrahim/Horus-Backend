<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Auth;

use App\Support\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\RefreshToken;
use Modules\Auth\Models\User;
use Modules\Auth\Support\ThrowsAuthExceptions;

final class PasswordService extends BaseService
{
    use ThrowsAuthExceptions;

    public function __construct(
        private readonly OtpService $otpService,
    ) {}

    public function forgotPassword(array $attributes): array
    {
        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        if ($user !== null) {
            $this->otpService->issue(
                mobile: $user->mobile,
                purpose: 'forgot_password',
                userId: (int) $user->id,
            );
        }

        return [
            'otp_sent' => true,
            'mobile' => $attributes['mobile'],
        ];
    }

    public function resetPassword(array $attributes): array
    {
        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        if ($user === null) {
            $this->unauthorized('Invalid reset request.');
        }

        $this->otpService->verify(
            mobile: (string) $attributes['mobile'],
            purpose: 'forgot_password',
            plainCode: (string) $attributes['code'],
        );

        $this->transaction(function () use ($attributes, $user): void {
            $user->update([
                'password' => Hash::make((string) $attributes['password']),
            ]);

            RefreshToken::query()
                ->where('user_id', $user->id)
                ->whereNull('revoked_at')
                ->update([
                    'revoked_at' => now(),
                ]);
        });

        return [
            'password_reset' => true,
            'mobile' => $attributes['mobile'],
        ];
    }

    public function changePassword(User $user, array $attributes): array
    {
        if (! Hash::check((string) $attributes['current_password'], (string) $user->password)) {
            $this->unauthorized('Current password is incorrect.');
        }

        $this->transaction(function () use ($attributes, $user): void {
            $user->update([
                'password' => Hash::make((string) $attributes['password']),
            ]);

            RefreshToken::query()
                ->where('user_id', $user->id)
                ->whereNull('revoked_at')
                ->update([
                    'revoked_at' => now(),
                ]);
        });

        return [
            'password_changed' => true,
        ];
    }
}
