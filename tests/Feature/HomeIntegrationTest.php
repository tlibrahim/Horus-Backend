<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class HomeIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Hit the home route, expect 200 and database contains users created by factory.
     */
    public function test_home_returns_200_and_users_present(): void
    {
        User::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertDatabaseCount('users', 3);
    }
}
