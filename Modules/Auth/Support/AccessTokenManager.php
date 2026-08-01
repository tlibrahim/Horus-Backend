<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

final class AccessTokenManager
{
    public static function issue(
        int $userId,
        string $refreshToken,
        ?CarbonInterface $expiresAt = null,
    ): string {
        $expiration = $expiresAt?->timestamp ?? now()->addMinutes(self::ttlMinutes())->timestamp;

        $payload = [
            'uid' => $userId,
            'rt' => $refreshToken,
            'exp' => $expiration,
        ];

        $encodedPayload = self::base64UrlEncode(
            json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}',
        );

        $signature = hash_hmac('sha256', $encodedPayload, self::key());

        return $encodedPayload.'.'.$signature;
    }

    public static function parse(string $token): ?array
    {
        $parts = explode('.', $token, 2);

        if (count($parts) !== 2) {
            return null;
        }

        [$encodedPayload, $signature] = $parts;

        $expected = hash_hmac('sha256', $encodedPayload, self::key());

        if (! hash_equals($expected, $signature)) {
            return null;
        }

        $decoded = self::base64UrlDecode($encodedPayload);

        if ($decoded === null) {
            return null;
        }

        /** @var mixed $payload */
        $payload = json_decode($decoded, true);

        if (! is_array($payload)) {
            return null;
        }

        $uid = $payload['uid'] ?? null;
        $rt = $payload['rt'] ?? null;
        $exp = $payload['exp'] ?? null;

        if (! is_int($uid) || ! is_string($rt) || ! is_int($exp)) {
            return null;
        }

        if (Carbon::createFromTimestamp($exp)->isPast()) {
            return null;
        }

        return [
            'user_id' => $uid,
            'refresh_token' => $rt,
            'expires_at' => Carbon::createFromTimestamp($exp),
        ];
    }

    private static function ttlMinutes(): int
    {
        return (int) data_get(config('auth', []), 'access_token_ttl_minutes', 15);
    }

    private static function key(): string
    {
        return (string) (
            config('auth.jwt_secret')
            ?? config('app.key', 'auth-access-token-key')
        );
    }

    private static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $value): ?string
    {
        $remainder = strlen($value) % 4;

        if ($remainder > 0) {
            $value .= str_repeat('=', 4 - $remainder);
        }

        $decoded = base64_decode(strtr($value, '-_', '+/'), true);

        return $decoded === false ? null : $decoded;
    }
}
