<?php

namespace Modules\Core\Tests\Unit\Models;

use Illuminate\Support\Facades\Hash;
use Modules\Core\Models\User;
use Modules\Core\Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function test_it_generates_uuid(): void
    {
        $user = User::create([
            'first_name' => 'Ibrahim',
            'last_name' => 'Mahmoud',
            'email' => 'ibrahim@test.com',
            'phone' => '201111111111',
            'password' => Hash::make('password'),
        ]);

        $this->assertNotNull($user->uuid);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-fA-F-]{36}$/',
            $user->uuid
        );
    }

    /** @test */
    public function test_password_is_hashed(): void
    {
        $password = 'secret123';

        $user = User::create([
            'first_name' => 'Ibrahim',
            'last_name' => 'Mahmoud',
            'email' => 'password@test.com',
            'phone' => '201111111112',
            'password' => Hash::make($password),
        ]);

        $this->assertTrue(
            Hash::check($password, $user->password)
        );
    }

    /** @test */
    public function test_user_uses_soft_deletes(): void
    {
        $user = User::create([
            'first_name' => 'Soft',
            'last_name' => 'Delete',
            'email' => 'soft@test.com',
            'phone' => '201111111113',
            'password' => Hash::make('password'),
        ]);

        $user->delete();

        $this->assertSoftDeleted($user);
    }
}
