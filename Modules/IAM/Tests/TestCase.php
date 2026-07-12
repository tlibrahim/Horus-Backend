<?php

declare(strict_types=1);

namespace Modules\IAM\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\IAM\Database\Seeders\IAMDatabaseSeeder;
use Modules\Tests\Traits\ApiAssertions;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use ApiAssertions;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(IAMDatabaseSeeder::class);
    }

    protected function apiHeaders(array $headers = []): array
    {
        return array_merge([
            'Accept' => 'application/json',
        ], $headers);
    }

    protected function validRoleData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Support Agent',
            'slug' => 'support-agent',
            'description' => 'Support team role',
            'is_system' => false,
            'is_active' => true,
        ], $overrides);
    }

    protected function validPermissionData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'roles.export',
            'code' => 'roles.export',
            'group' => 'iam',
            'description' => 'Can export roles',
        ], $overrides);
    }
}
