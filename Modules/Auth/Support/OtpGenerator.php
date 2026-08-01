<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

final class OtpGenerator
{
    public function generate(): string
    {
        return (string) random_int(100000, 999999);
    }
}
