<?php

declare(strict_types=1);

namespace Modules\IAM\Tests\Feature;

use Modules\IAM\Models\Permission;
use Modules\IAM\Tests\TestCase;

final class PermissionControllerTest extends TestCase
{
    public function test_it_can_list_permissions(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.permissions.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_return_permission_options(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.permissions.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_a_permission(): void
    {
        $permission = Permission::query()->firstOrFail();

        $response = $this->getJson(
            route('api.v1.iam.permissions.show', $permission),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $response->assertJsonPath('data.id', $permission->id);
    }

    public function test_it_returns_not_found_for_unknown_permission(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.permissions.show', 999999),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_permission(): void
    {
        $response = $this->postJson(
            route('api.v1.iam.permissions.store'),
            $this->validPermissionData([
                'name' => 'reports.view',
                'code' => 'reports.view',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('permissions', [
            'code' => 'reports.view',
            'group' => 'iam',
        ]);
    }

    public function test_it_validates_store_permission_request(): void
    {
        $response = $this->postJson(
            route('api.v1.iam.permissions.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'code',
            'group',
        ]);
    }

    public function test_it_can_update_permission(): void
    {
        $permission = Permission::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.iam.permissions.update', $permission),
            $this->validPermissionData([
                'name' => 'roles.audit',
                'code' => 'roles.audit',
                'group' => 'iam',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'code' => 'roles.audit',
        ]);
    }

    public function test_it_can_delete_permission(): void
    {
        $permission = Permission::query()->create(
            $this->validPermissionData([
                'name' => 'temporary.permission',
                'code' => 'temporary.permission',
            ]),
        );

        $response = $this->deleteJson(
            route('api.v1.iam.permissions.destroy', $permission),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('permissions', [
            'id' => $permission->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_permission(): void
    {
        $response = $this->deleteJson(
            route('api.v1.iam.permissions.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
