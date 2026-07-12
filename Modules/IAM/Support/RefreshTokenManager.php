<?php

declare(strict_types=1);

namespace Modules\IAM\Support;

use Illuminate\Support\Str;

final class RefreshTokenManager
{
    public function issue(): string
    {
        return (string) Str::uuid();
    }

    public function hash(string $plainToken): string
    {
        return hash('sha256', $plainToken);
    }
}
