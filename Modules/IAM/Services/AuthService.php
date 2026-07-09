<?php

declare(strict_types=1);

namespace Modules\IAM\Services;

use App\Support\Enums\ProblemType;
use App\Support\Services\BaseService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\IAM\Contracts\Services\AuthServiceInterface;
use Modules\IAM\Models\OtpCode;
use Modules\IAM\Models\RefreshToken;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserDevice;
use Modules\IAM\Support\AccessTokenManager;
use Symfony\Component\HttpFoundation\Response;

final class AuthService extends BaseService implements AuthServiceInterface
{
    public function register(array $attributes): array
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

        $otp = $this->issueOtp(
            mobile: $user->mobile,
            purpose: 'register',
            userId: $user->id,
        );

        return [
            'user' => $user,
            'otp_sent' => true,
            'expires_at' => $otp->expires_at,
        ];
    }

    public function verifyOtp(array $attributes): array
    {
        $otp = OtpCode::query()
            ->where('mobile', $attributes['mobile'])
            ->where('purpose', $attributes['purpose'])
            ->whereNull('verified_at')
            ->orderByDesc('id')
            ->first();

        if ($otp === null) {
            $this->unauthorized('Invalid OTP code.');
        }

        if ($otp->attempts >= $this->otpMaxVerifyAttempts()) {
            $this->tooManyRequests('OTP attempts limit exceeded.');
        }

        if ($otp->expires_at->isPast()) {
            $this->unauthorized('OTP code expired.');
        }

        $isValid = $otp->code_hash !== null
            ? Hash::check((string) $attributes['code'], $otp->code_hash)
            : hash_equals((string) $otp->code, (string) $attributes['code']);

        if (! $isValid) {
            $otp->increment('attempts');

            $this->unauthorized('Invalid OTP code.');
        }

        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        $this->transaction(function () use ($otp, $user, $attributes): void {
            $otp->update([
                'verified_at' => now(),
            ]);

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

        $otp = $this->issueOtp(
            mobile: $attributes['mobile'],
            purpose: $attributes['purpose'],
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

        [$device, $refreshToken] = $this->transaction(function () use ($attributes, $user): array {
            /** @var UserDevice $device */
            $device = UserDevice::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'device_uuid' => $attributes['device_uuid'] ?? (string) Str::uuid(),
                ],
                [
                    'platform' => $attributes['platform'] ?? 'web',
                    'device_name' => $attributes['device_name'] ?? 'Unknown Device',
                    'os_version' => $attributes['os_version'] ?? null,
                    'app_version' => $attributes['app_version'] ?? null,
                    'last_login_at' => now(),
                    'is_active' => true,
                ],
            );

            /** @var RefreshToken $refreshToken */
            $refreshToken = RefreshToken::query()->create([
                'user_id' => $user->id,
                'user_device_id' => $device->id,
                'token' => (string) Str::uuid(),
                'expires_at' => now()->addDays($this->refreshTokenTtlDays()),
            ]);

            $user->update([
                'last_login_at' => now(),
            ]);

            return [$device, $refreshToken];
        });

        return [
            'user' => $user->fresh(),
            'access_token' => AccessTokenManager::issue(
                userId: (int) $user->id,
                refreshToken: $refreshToken->token,
            ),
            'refresh_token' => $refreshToken->token,
            'token_type' => 'Bearer',
            'expires_at' => $refreshToken->expires_at,
            'device' => $device,
        ];
    }

    public function refresh(string $refreshToken): array
    {
        $token = RefreshToken::query()
            ->where('token', $refreshToken)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if ($token === null) {
            $this->unauthorized('Invalid refresh token.');
        }

        /** @var RefreshToken $newToken */
        $newToken = $this->transaction(function () use ($token): RefreshToken {
            $token->update([
                'revoked_at' => now(),
            ]);

            /** @var RefreshToken $created */
            $created = RefreshToken::query()->create([
                'user_id' => $token->user_id,
                'user_device_id' => $token->user_device_id,
                'token' => (string) Str::uuid(),
                'expires_at' => now()->addDays($this->refreshTokenTtlDays()),
            ]);

            return $created;
        });

        $user = User::query()->findOrFail($newToken->user_id);

        return [
            'user' => $user,
            'access_token' => AccessTokenManager::issue(
                userId: (int) $user->id,
                refreshToken: $newToken->token,
            ),
            'refresh_token' => $newToken->token,
            'token_type' => 'Bearer',
            'expires_at' => $newToken->expires_at,
        ];
    }

    public function logout(User $user, ?string $refreshToken = null): void
    {
        $query = RefreshToken::query()
            ->where('user_id', $user->id)
            ->whereNull('revoked_at');

        if ($refreshToken !== null) {
            $query->where('token', $refreshToken);
        }

        $query->update([
            'revoked_at' => now(),
        ]);
    }

    public function logoutAll(User $user): void
    {
        RefreshToken::query()
            ->where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->update([
                'revoked_at' => now(),
            ]);
    }

    public function forgotPassword(array $attributes): array
    {
        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        if ($user !== null) {
            $this->issueOtp(
                mobile: $user->mobile,
                purpose: 'forgot_password',
                userId: $user->id,
            );
        }

        return [
            'otp_sent' => true,
            'mobile' => $attributes['mobile'],
        ];
    }

    public function resetPassword(array $attributes): array
    {
        $otp = OtpCode::query()
            ->where('mobile', $attributes['mobile'])
            ->where('purpose', 'forgot_password')
            ->whereNull('verified_at')
            ->orderByDesc('id')
            ->first();

        if ($otp === null) {
            $this->unauthorized('Invalid OTP code.');
        }

        if ($otp->attempts >= $this->otpMaxVerifyAttempts()) {
            $this->tooManyRequests('OTP attempts limit exceeded.');
        }

        if ($otp->expires_at->isPast()) {
            $this->unauthorized('OTP code expired.');
        }

        $isValid = $otp->code_hash !== null
            ? Hash::check((string) $attributes['code'], $otp->code_hash)
            : hash_equals((string) $otp->code, (string) $attributes['code']);

        if (! $isValid) {
            $otp->increment('attempts');

            $this->unauthorized('Invalid OTP code.');
        }

        $user = User::query()
            ->where('mobile', $attributes['mobile'])
            ->first();

        if ($user === null) {
            $this->unauthorized('Invalid reset request.');
        }

        $this->transaction(function () use ($otp, $attributes, $user): void {
            $otp->update([
                'verified_at' => now(),
            ]);

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

    private function issueOtp(string $mobile, string $purpose, ?int $userId): OtpCode
    {
        $rateKey = sprintf('iam:otp:issue:%s:%s', $purpose, $mobile);

        if (RateLimiter::tooManyAttempts($rateKey, $this->otpIssueMaxAttempts())) {
            $this->tooManyRequests('Too many OTP requests. Please try again later.');
        }

        RateLimiter::hit($rateKey, $this->otpIssueDecaySeconds());

        $plainCode = $this->generateOtpCode();

        /** @var OtpCode */
        return OtpCode::query()->create([
            'user_id' => $userId,
            'mobile' => $mobile,
            'purpose' => $purpose,
            'code' => '******',
            'code_hash' => Hash::make($plainCode),
            'expires_at' => now()->addMinutes($this->otpTtlMinutes()),
            'attempts' => 0,
        ]);
    }

    private function generateOtpCode(): string
    {
        return (string) random_int(100000, 999999);
    }

    private function unauthorized(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::Unauthorized->uri(),
                    'title' => ProblemType::Unauthorized->title(),
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_UNAUTHORIZED)
        );
    }

    private function forbidden(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::Forbidden->uri(),
                    'title' => ProblemType::Forbidden->title(),
                    'status' => Response::HTTP_FORBIDDEN,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_FORBIDDEN)
        );
    }

    private function tooManyRequests(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::TooManyRequests->uri(),
                    'title' => ProblemType::TooManyRequests->title(),
                    'status' => Response::HTTP_TOO_MANY_REQUESTS,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_TOO_MANY_REQUESTS)
        );
    }

    private function otpTtlMinutes(): int
    {
        return (int) data_get(config('iam.auth', []), 'otp_ttl_minutes', 10);
    }

    private function otpMaxVerifyAttempts(): int
    {
        return (int) data_get(config('iam.auth', []), 'otp_max_verify_attempts', 5);
    }

    private function otpIssueMaxAttempts(): int
    {
        return (int) data_get(config('iam.auth', []), 'otp_issue_max_attempts', 3);
    }

    private function otpIssueDecaySeconds(): int
    {
        return (int) data_get(config('iam.auth', []), 'otp_issue_decay_seconds', 60);
    }

    private function refreshTokenTtlDays(): int
    {
        return (int) data_get(config('iam.auth', []), 'refresh_token_ttl_days', 30);
    }
}
