<?php

declare(strict_types=1);

namespace Modules\IAM\Tests\Feature;

use Modules\IAM\Models\Permission;
use Modules\IAM\Models\Role;
use Modules\IAM\Tests\TestCase;

final class RoleControllerTest extends TestCase
{
    public function test_it_can_list_roles(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.roles.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_return_role_options(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.roles.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_a_role(): void
    {
        $role = Role::query()->firstOrFail();

        $response = $this->getJson(
            route('api.v1.iam.roles.show', $role),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $response->assertJsonPath('data.id', $role->id);
    }

    public function test_it_returns_not_found_for_unknown_role(): void
    {
        $response = $this->getJson(
            route('api.v1.iam.roles.show', 999999),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_role(): void
    {
        $response = $this->postJson(
            route('api.v1.iam.roles.store'),
            $this->validRoleData([
                'name' => 'Fleet Manager',
                'slug' => 'fleet-manager',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('roles', [
            'name' => 'Fleet Manager',
            'slug' => 'fleet-manager',
        ]);
    }

    public function test_it_validates_store_role_request(): void
    {
        $response = $this->postJson(
            route('api.v1.iam.roles.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'slug',
        ]);
    }

    public function test_it_can_update_role(): void
    {
        $role = Role::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.iam.roles.update', $role),
            $this->validRoleData([
                'name' => 'Updated Role Name',
                'slug' => 'updated-role-name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Updated Role Name',
            'slug' => 'updated-role-name',
        ]);
    }

    public function test_it_can_toggle_role_status(): void
    {
        $role = Role::query()->firstOrFail();

        $response = $this->patchJson(
            route('api.v1.iam.roles.toggleStatus', $role),
            [
                'is_active' => ! $role->is_active,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'is_active' => ! $role->is_active,
        ]);
    }

    public function test_it_can_activate_role(): void
    {
        $role = Role::query()->firstOrFail();

        $role->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.iam.roles.activate', $role),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_role(): void
    {
        $role = Role::query()->firstOrFail();

        $role->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.iam.roles.deactivate', $role),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_get_role_permissions(): void
    {
        $role = Role::query()->firstOrFail();

        $role->permissions()->sync(
            Permission::query()->take(2)->pluck('id')->all(),
        );

        $response = $this->getJson(
            route('api.v1.iam.roles.permissions', $role),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_sync_role_permissions(): void
    {
        $role = Role::query()->firstOrFail();

        $permissionIds = Permission::query()
            ->orderBy('id')
            ->limit(3)
            ->pluck('id')
            ->all();

        $response = $this->putJson(
            route('api.v1.iam.roles.syncPermissions', $role),
            [
                'permissions' => $permissionIds,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertSame(
            $permissionIds,
            $role->fresh()->permissions()->orderBy('permissions.id')->pluck('permissions.id')->all(),
        );
    }

    public function test_it_can_delete_role(): void
    {
        $role = Role::query()
            ->where('is_system', false)
            ->first();

        if ($role === null) {
            $role = Role::query()->create($this->validRoleData([
                'name' => 'Temporary Role',
                'slug' => 'temporary-role',
                'is_system' => false,
            ]));
        }

        $response = $this->deleteJson(
            route('api.v1.iam.roles.destroy', $role),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_role(): void
    {
        $response = $this->deleteJson(
            route('api.v1.iam.roles.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
