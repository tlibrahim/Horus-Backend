<?php

declare(strict_types=1);

namespace Modules\IAM\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Modules\IAM\Models\OtpCode;
use Modules\IAM\Models\RefreshToken;
use Modules\IAM\Models\User;
use Modules\IAM\Support\AccessTokenManager;
use Modules\IAM\Tests\TestCase;

final class AuthControllerTest extends TestCase
{
    public function test_it_can_register(): void
    {
        $response = $this->postJson(
            route('api.v1.iam.auth.register'),
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'mobile' => '+201111111111',
                'email' => 'john.doe@example.com',
                'password' => 'Password@123',
                'password_confirmation' => 'Password@123',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('users', [
            'mobile' => '+201111111111',
            'email' => 'john.doe@example.com',
            'is_verified' => false,
        ]);

        $this->assertDatabaseHas('otp_codes', [
            'mobile' => '+201111111111',
            'purpose' => 'register',
        ]);
    }

    public function test_it_can_verify_otp_for_registration(): void
    {
        $user = User::query()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'mobile' => '+201222222222',
            'password' => Hash::make('Password@123'),
            'is_verified' => false,
        ]);

        $otp = OtpCode::query()->create([
            'user_id' => $user->id,
            'mobile' => $user->mobile,
            'code_hash' => Hash::make('123456'),
            'purpose' => 'register',
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.verifyOtp'),
            [
                'mobile' => $user->mobile,
                'code' => '123456',
                'purpose' => 'register',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertNotNull($otp->fresh()->verified_at);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_verified' => true,
        ]);
    }

    public function test_it_can_resend_otp(): void
    {
        User::query()->create([
            'first_name' => 'Mark',
            'last_name' => 'Smith',
            'mobile' => '+201333333333',
            'password' => Hash::make('Password@123'),
            'is_verified' => false,
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.resendOtp'),
            [
                'mobile' => '+201333333333',
                'purpose' => 'register',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('otp_codes', [
            'mobile' => '+201333333333',
            'purpose' => 'register',
        ]);
    }

    public function test_it_can_login_and_get_tokens(): void
    {
        $user = User::query()->create([
            'first_name' => 'Ali',
            'last_name' => 'Hassan',
            'mobile' => '+201444444444',
            'email' => 'ali@example.com',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.login'),
            [
                'login' => 'ali@example.com',
                'password' => 'Password@123',
                'device_uuid' => '11111111-1111-1111-1111-111111111111',
                'platform' => 'ios',
                'device_name' => 'iPhone',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('refresh_tokens', [
            'user_id' => $user->id,
            'revoked_at' => null,
        ]);
    }

    public function test_it_can_refresh_token(): void
    {
        $user = User::query()->create([
            'first_name' => 'Nour',
            'last_name' => 'Ahmed',
            'mobile' => '+201555555555',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $plainRefreshToken = '22222222-2222-2222-2222-222222222222';

        $token = RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $plainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.refresh'),
            [
                'refresh_token' => $plainRefreshToken,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertNotNull($token->fresh()->revoked_at);
    }

    public function test_it_can_logout(): void
    {
        $user = User::query()->create([
            'first_name' => 'Alaa',
            'last_name' => 'Mohamed',
            'mobile' => '+201666666666',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $plainRefreshToken = '33333333-3333-3333-3333-333333333333';

        $token = RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $plainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $accessToken = AccessTokenManager::issue(
            userId: (int) $user->id,
            refreshToken: $plainRefreshToken,
        );

        $response = $this->postJson(
            route('api.v1.iam.auth.logout'),
            [],
            $this->apiHeaders([
                'Authorization' => 'Bearer '.$accessToken,
            ]),
        );

        $this->assertSuccessResponse($response);

        $this->assertNotNull($token->fresh()->revoked_at);
    }

    public function test_it_can_logout_all(): void
    {
        $user = User::query()->create([
            'first_name' => 'Sara',
            'last_name' => 'Ibrahim',
            'mobile' => '+201777777777',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $firstPlainRefreshToken = '44444444-4444-4444-4444-444444444444';

        $token = RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $firstPlainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $accessToken = AccessTokenManager::issue(
            userId: (int) $user->id,
            refreshToken: $firstPlainRefreshToken,
        );

        $secondPlainRefreshToken = '55555555-5555-5555-5555-555555555555';

        RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $secondPlainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.logoutAll'),
            [],
            $this->apiHeaders([
                'Authorization' => 'Bearer '.$accessToken,
            ]),
        );

        $this->assertSuccessResponse($response);

        $this->assertSame(
            0,
            RefreshToken::query()
                ->where('user_id', $user->id)
                ->whereNull('revoked_at')
                ->count(),
        );
    }

    public function test_it_can_send_forgot_password_otp(): void
    {
        User::query()->create([
            'first_name' => 'Mina',
            'last_name' => 'Kamel',
            'mobile' => '+201888888888',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.forgotPassword'),
            [
                'mobile' => '+201888888888',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('otp_codes', [
            'mobile' => '+201888888888',
            'purpose' => 'forgot_password',
        ]);
    }

    public function test_it_can_reset_password(): void
    {
        $user = User::query()->create([
            'first_name' => 'Kareem',
            'last_name' => 'Said',
            'mobile' => '+201999999999',
            'password' => Hash::make('OldPassword@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $otp = OtpCode::query()->create([
            'user_id' => $user->id,
            'mobile' => $user->mobile,
            'code_hash' => Hash::make('654321'),
            'purpose' => 'forgot_password',
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson(
            route('api.v1.iam.auth.resetPassword'),
            [
                'mobile' => $user->mobile,
                'code' => '654321',
                'password' => 'NewPassword@123',
                'password_confirmation' => 'NewPassword@123',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertTrue(
            Hash::check('NewPassword@123', (string) $user->fresh()->password),
        );

        $this->assertNotNull($otp->fresh()->verified_at);
    }

    public function test_it_can_change_password(): void
    {
        $user = User::query()->create([
            'first_name' => 'Ramy',
            'last_name' => 'Nader',
            'mobile' => '+201123123123',
            'password' => Hash::make('Current@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $plainRefreshToken = '66666666-6666-6666-6666-666666666666';

        $token = RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $plainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $accessToken = AccessTokenManager::issue(
            userId: (int) $user->id,
            refreshToken: $plainRefreshToken,
        );

        $response = $this->postJson(
            route('api.v1.iam.auth.changePassword'),
            [
                'current_password' => 'Current@123',
                'password' => 'Changed@123',
                'password_confirmation' => 'Changed@123',
            ],
            $this->apiHeaders([
                'Authorization' => 'Bearer '.$accessToken,
            ]),
        );

        $this->assertSuccessResponse($response);

        $this->assertTrue(
            Hash::check('Changed@123', (string) $user->fresh()->password),
        );
    }

    public function test_it_can_get_current_user(): void
    {
        $user = User::query()->create([
            'first_name' => 'Nadine',
            'last_name' => 'Fathy',
            'mobile' => '+201321321321',
            'password' => Hash::make('Password@123'),
            'is_verified' => true,
            'mobile_verified_at' => now(),
            'is_active' => true,
        ]);

        $plainRefreshToken = '77777777-7777-7777-7777-777777777777';

        $token = RefreshToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $plainRefreshToken),
            'expires_at' => now()->addDays(30),
        ]);

        $accessToken = AccessTokenManager::issue(
            userId: (int) $user->id,
            refreshToken: $plainRefreshToken,
        );

        $response = $this->getJson(
            route('api.v1.iam.auth.me'),
            $this->apiHeaders([
                'Authorization' => 'Bearer '.$accessToken,
            ]),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath('data.id', $user->id);
    }

    public function test_resend_otp_is_throttled_after_max_attempts(): void
    {
        User::query()->create([
            'first_name' => 'Throttle',
            'last_name' => 'User',
            'mobile' => '+201000111222',
            'password' => Hash::make('Password@123'),
            'is_verified' => false,
        ]);

        for ($i = 0; $i < 3; $i++) {
            $response = $this->postJson(
                route('api.v1.iam.auth.resendOtp'),
                [
                    'mobile' => '+201000111222',
                    'purpose' => 'register',
                ],
                $this->apiHeaders(),
            );

            $this->assertSuccessResponse($response);
        }

        $response = $this->postJson(
            route('api.v1.iam.auth.resendOtp'),
            [
                'mobile' => '+201000111222',
                'purpose' => 'register',
            ],
            $this->apiHeaders(),
        );

        $response->assertStatus(429);
    }
}
