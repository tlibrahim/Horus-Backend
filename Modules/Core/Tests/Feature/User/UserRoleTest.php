<?php

namespace Modules\Core\Tests\Feature\User;

use Modules\Core\Enums\Role;
use Modules\Core\Models\User;
use Modules\Core\Tests\TestCase;

class UserRoleTest extends TestCase
{
    /** @test */
    public function test_user_can_be_assigned_role(): void
    {
        $user = User::factory()->create();

        $user->assignRole(Role::SUPER_ADMIN->value);

        $this->assertTrue(
            $user->hasRole(Role::SUPER_ADMIN->value)
        );
    }
}
