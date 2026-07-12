<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Middleware;

use App\Support\Enums\ProblemType;
use App\Support\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Modules\IAM\Models\RefreshToken;
use Modules\IAM\Support\AccessTokenManager;
use Symfony\Component\HttpFoundation\Response;

final class IamAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = trim((string) $request->bearerToken());

        if ($accessToken === '') {
            return ApiResponse::error(
                type: ProblemType::Unauthorized,
                detail: __('api.errors.unauthorized.detail'),
                status: Response::HTTP_UNAUTHORIZED,
            );
        }

        $payload = AccessTokenManager::parse($accessToken);

        if ($payload === null) {
            return ApiResponse::error(
                type: ProblemType::Unauthorized,
                detail: __('api.errors.unauthorized.detail'),
                status: Response::HTTP_UNAUTHORIZED,
            );
        }

        $refreshToken = RefreshToken::query()
            ->with('user')
            ->where('token_hash', hash('sha256', $payload['refresh_token']))
            ->where('user_id', $payload['user_id'])
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();

        if ($refreshToken === null || $refreshToken->user === null) {
            return ApiResponse::error(
                type: ProblemType::Unauthorized,
                detail: __('api.errors.unauthorized.detail'),
                status: Response::HTTP_UNAUTHORIZED,
            );
        }

        auth()->setUser($refreshToken->user);

        $request->setUserResolver(
            fn () => $refreshToken->user,
        );

        $request->attributes->set('iam_refresh_token', $refreshToken);
        $request->attributes->set('iam_access_refresh_token', $payload['refresh_token']);

        return $next($request);
    }
}
