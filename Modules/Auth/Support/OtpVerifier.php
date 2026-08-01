<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\OtpCode;

final class OtpVerifier
{
    public function verify(OtpCode $otpCode, string $plainCode): bool
    {
        if ($otpCode->code_hash === null) {
            return false;
        }

        return Hash::check($plainCode, $otpCode->code_hash);
    }
}
