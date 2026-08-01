<?php

declare(strict_types=1);

namespace Modules\Auth\Services\Auth;

use App\Support\Services\BaseService;
use Modules\Auth\Models\RefreshToken;
use Modules\Auth\Models\User;
use Modules\Auth\Support\AccessTokenManager;
use Modules\Auth\Support\RefreshTokenManager;
use Modules\Auth\Support\ThrowsAuthExceptions;

final class TokenService extends BaseService
{
    use ThrowsAuthExceptions;

    public function __construct(
        private readonly DeviceService $devices,
        private readonly RefreshTokenManager $refreshTokenManager,
    ) {}

    public function issueForLogin(User $user, array $attributes): array
    {
        [$device, $refreshToken, $plainRefreshToken] = $this->transaction(function () use ($attributes, $user): array {
            $device = $this->devices->resolve($user, $attributes);

            [$refreshToken, $plainRefreshToken] = $this->createRefreshToken(
                userId: (int) $user->id,
                userSessionId: null,
            );

            $user->update([
                'last_login_at' => now(),
            ]);

            return [$device, $refreshToken, $plainRefreshToken];
        });

        return [
            'user' => $user->fresh(),
            'access_token' => AccessTokenManager::issue(
                userId: (int) $user->id,
                refreshToken: $plainRefreshToken,
            ),
            'refresh_token' => $plainRefreshToken,
            'token_type' => 'Bearer',
            'expires_at' => $refreshToken->expires_at,
            'device' => $device,
        ];
    }

    public function refresh(string $refreshToken): array
    {
        $token = RefreshToken::query()
            ->where('token_hash', $this->refreshTokenManager->hash($refreshToken))
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if ($token === null) {
            $this->unauthorized('Invalid refresh token.');
        }

        [$newToken, $newPlainRefreshToken] = $this->transaction(function () use ($token): array {
            $token->update([
                'revoked_at' => now(),
            ]);

            return $this->createRefreshToken(
                userId: (int) $token->user_id,
                userSessionId: $token->user_session_id !== null ? (int) $token->user_session_id : null,
            );
        });

        $user = User::query()->findOrFail($newToken->user_id);

        return [
            'user' => $user,
            'access_token' => AccessTokenManager::issue(
                userId: (int) $user->id,
                refreshToken: $newPlainRefreshToken,
            ),
            'refresh_token' => $newPlainRefreshToken,
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
            $query->where(
                'token_hash',
                $this->refreshTokenManager->hash($refreshToken),
            );
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

    private function createRefreshToken(int $userId, ?int $userSessionId = null): array
    {
        $plainRefreshToken = $this->refreshTokenManager->issue();

        /** @var RefreshToken $refreshToken */
        $refreshToken = RefreshToken::query()->create([
            'user_id' => $userId,
            'user_session_id' => $userSessionId,
            'token_hash' => $this->refreshTokenManager->hash($plainRefreshToken),
            'expires_at' => now()->addDays($this->refreshTokenTtlDays()),
        ]);

        return [$refreshToken, $plainRefreshToken];
    }

    private function refreshTokenTtlDays(): int
    {
        return (int) data_get(config('auth', []), 'refresh_token_ttl_days', 30);
    }
}
