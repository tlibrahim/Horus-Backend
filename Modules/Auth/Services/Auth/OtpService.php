<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Auth;

use App\Support\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Auth\Models\OtpCode;
use Modules\Auth\Support\OtpGenerator;
use Modules\Auth\Support\OtpSender;
use Modules\Auth\Support\OtpVerifier;
use Modules\Auth\Support\ThrowsAuthExceptions;

final class OtpService extends BaseService
{
    use ThrowsAuthExceptions;

    public function __construct(
        private readonly OtpGenerator $generator,
        private readonly OtpVerifier $verifier,
        private readonly OtpSender $sender,
    ) {}

    public function issue(string $mobile, string $purpose, ?int $userId): OtpCode
    {
        $rateKey = sprintf('auth:otp:issue:%s:%s', $purpose, $mobile);

        if (RateLimiter::tooManyAttempts($rateKey, $this->otpIssueMaxAttempts())) {
            $this->tooManyRequests('Too many OTP requests. Please try again later.');
        }

        RateLimiter::hit($rateKey, $this->otpIssueDecaySeconds());

        $plainCode = $this->generator->generate();

        if (! app()->isProduction()) {
            \Log::info('Generated OTP', [
                'user_id' => $userId,
                'phone' => $mobile,
                'otp' => $plainCode,
            ]);
        }

        /** @var OtpCode $otp */
        $otp = OtpCode::query()->create([
            'user_id' => $userId,
            'mobile' => $mobile,
            'purpose' => $purpose,
            'code_hash' => Hash::make($plainCode),
            'expires_at' => now()->addMinutes($this->otpTtlMinutes()),
            'attempts' => 0,
        ]);

        $this->sender->send($mobile, $plainCode, $purpose);

        return $otp;
    }

    public function verify(string $mobile, string $purpose, string $plainCode): OtpCode
    {
        $otp = OtpCode::query()
            ->where('mobile', $mobile)
            ->where('purpose', $purpose)
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

        if (! $this->verifier->verify($otp, $plainCode)) {
            $otp->increment('attempts');

            $this->unauthorized('Invalid OTP code.');
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        return $otp;
    }

    private function otpTtlMinutes(): int
    {
        return (int) data_get(config('auth', []), 'otp_ttl_minutes', 10);
    }

    private function otpMaxVerifyAttempts(): int
    {
        return (int) data_get(config('auth', []), 'otp_max_verify_attempts', 5);
    }

    private function otpIssueMaxAttempts(): int
    {
        return (int) data_get(config('auth', []), 'otp_issue_max_attempts', 3);
    }

    private function otpIssueDecaySeconds(): int
    {
        return (int) data_get(config('auth', []), 'otp_issue_decay_seconds', 60);
    }
}
