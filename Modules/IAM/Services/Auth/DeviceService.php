<?php

declare(strict_types=1);

namespace Modules\IAM\Services\Auth;

use Illuminate\Support\Str;
use Modules\IAM\Models\User;
use Modules\IAM\Models\UserDevice;

final class DeviceService
{
    public function resolve(User $user, array $attributes): UserDevice
    {
        $userAgent = (string) ($attributes['user_agent'] ?? request()?->userAgent() ?? '');

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
                'ip_address' => $attributes['ip_address'] ?? request()?->ip(),
                'user_agent' => $userAgent !== '' ? $userAgent : null,
                'browser' => $attributes['browser'] ?? $this->resolveBrowser($userAgent),
                'country' => $attributes['country'] ?? null,
                'last_login_at' => now(),
                'last_used_at' => now(),
                'is_active' => true,
            ],
        );

        return $device;
    }

    private function resolveBrowser(string $userAgent): ?string
    {
        if ($userAgent === '') {
            return null;
        }

        return str($userAgent)->contains('Firefox')
            ? 'Firefox'
            : (str($userAgent)->contains('Edg')
                ? 'Edge'
                : (str($userAgent)->contains('Chrome')
                    ? 'Chrome'
                    : (str($userAgent)->contains('Safari') ? 'Safari' : 'Unknown')));
    }
}
