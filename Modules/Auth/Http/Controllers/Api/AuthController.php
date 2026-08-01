<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Contracts\Services\AuthServiceInterface;
use Modules\Auth\Http\Requests\Auth\ChangePasswordRequest;
use Modules\Auth\Http\Requests\Auth\ForgotPasswordRequest;
use Modules\Auth\Http\Requests\Auth\LoginRequest;
use Modules\Auth\Http\Requests\Auth\LogoutRequest;
use Modules\Auth\Http\Requests\Auth\RefreshRequest;
use Modules\Auth\Http\Requests\Auth\RegisterRequest;
use Modules\Auth\Http\Requests\Auth\ResendOtpRequest;
use Modules\Auth\Http\Requests\Auth\ResetPasswordRequest;
use Modules\Auth\Http\Requests\Auth\VerifyOtpRequest;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\Models\RefreshToken;
use Modules\Auth\Models\User;

final class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthServiceInterface $service,
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->service->register($request->validated());

        return $this->created(
            data: [
                'user' => UserResource::make($result['user']),
                'otp_sent' => $result['otp_sent'],
                'expires_at' => optional($result['expires_at'])->toISOString(),
            ],
        );
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $result = $this->service->verifyOtp($request->validated());

        return $this->success(
            data: [
                'verified' => $result['verified'],
                'purpose' => $result['purpose'],
                'mobile' => $result['mobile'],
                'user' => $result['user'] !== null ? UserResource::make($result['user']) : null,
            ],
        );
    }

    public function resendOtp(ResendOtpRequest $request): JsonResponse
    {
        $result = $this->service->resendOtp($request->validated());

        return $this->success(data: $result);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login($request->validated());

        return $this->success(
            data: [
                'user' => UserResource::make($result['user']),
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
                'token_type' => $result['token_type'],
                'expires_at' => optional($result['expires_at'])->toISOString(),
            ],
        );
    }

    public function refresh(RefreshRequest $request): JsonResponse
    {
        $result = $this->service->refresh((string) $request->validated('refresh_token'));

        return $this->success(
            data: [
                'user' => UserResource::make($result['user']),
                'access_token' => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
                'token_type' => $result['token_type'],
                'expires_at' => optional($result['expires_at'])->toISOString(),
            ],
        );
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        /** @var User|null $user */
        $user = auth()->user();

        if ($user !== null) {
            /** @var RefreshToken|null $token */
            $token = $request->attributes->get('auth_refresh_token');

            $this->service->logout(
                $user,
                $request->validated('refresh_token')
                    ?? $token?->token,
            );
        }

        return $this->success(data: ['logged_out' => true]);
    }

    public function logoutAll(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $this->service->logoutAll($user);

        return $this->success(data: ['logged_out_all' => true]);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->service->forgotPassword($request->validated());

        return $this->success(data: $result);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->service->resetPassword($request->validated());

        return $this->success(data: $result);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $result = $this->service->changePassword(
            $user,
            $request->validated(),
        );

        return $this->success(data: $result);
    }

    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return $this->success(
            data: UserResource::make($user),
        );
    }
}
