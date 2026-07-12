<?php

declare(strict_types=1);

namespace Modules\IAM\Support;

final class OtpSender
{
    public function send(string $mobile, string $code, string $purpose): void
    {
        // Intentionally lightweight for now.
        // Future channels: SMS, WhatsApp, Email, Firebase, Push notifications.
    }
}
