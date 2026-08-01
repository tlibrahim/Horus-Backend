<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Auth\Models\User;
use Modules\Vehicle\Enums\OwnershipType;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;
use Modules\Vehicle\Tests\TestCase;

final class VehicleOwnerControllerTest extends TestCase
{
    public function test_it_can_list_vehicle_owners(): void
    {
        $vehicle = Vehicle::factory()->create();

        VehicleOwner::factory()
            ->count(3)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicles.owners.index',
                $vehicle,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertCount(
            3,
            $response->json('data'),
        );
    }

    public function test_it_can_create_vehicle_owner(): void
    {
        $vehicle = Vehicle::factory()->create();

        $user = User::query()->firstOrFail();

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.owners.store',
                $vehicle,
            ),
            [
                'user_id' => $user->id,
                'ownership_type' => OwnershipType::OWNER->value,
                'is_primary' => true,
                'ownership_percentage' => 100,
                'started_at' => now()->subYear()->toDateString(),
                'ended_at' => null,
                'notes' => 'Current owner',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas(
            'vehicle_owners',
            [
                'vehicle_id' => $vehicle->id,
                'user_id' => $user->id,
                'ownership_type' => OwnershipType::OWNER->value,
                'is_primary' => true,
            ],
        );
    }

    public function test_it_can_show_vehicle_owner(): void
    {
        $owner = VehicleOwner::factory()->create();

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicle-owners.show',
                $owner,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $owner->id,
        );
    }

    public function test_it_can_update_vehicle_owner(): void
    {
        $owner = VehicleOwner::factory()->create();

        $user = User::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.vehicle.vehicle-owners.update',
                $owner,
            ),
            [
                'user_id' => $user->id,
                'ownership_type' => OwnershipType::COMPANY->value,
                'is_primary' => false,
                'ownership_percentage' => 75,
                'notes' => 'Updated owner',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas(
            'vehicle_owners',
            [
                'id' => $owner->id,
                'user_id' => $user->id,
                'ownership_type' => OwnershipType::COMPANY->value,
                'is_primary' => false,
            ],
        );
    }

    public function test_it_can_delete_vehicle_owner(): void
    {
        $owner = VehicleOwner::factory()->create();

        $response = $this->deleteJson(
            route(
                'api.v1.vehicle.vehicle-owners.destroy',
                $owner,
            ),
            [],
            $this->apiHeaders(),
        );

        $response->assertNoContent();

        $this->assertDatabaseMissing(
            'vehicle_owners',
            [
                'id' => $owner->id,
            ],
        );
    }

    public function test_it_validates_create_request(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.owners.store',
                $vehicle,
            ),
            [],
            $this->apiHeaders(),
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error' => [
                    'status' => 422,
                ],
            ]);

    }

    public function test_it_ensures_only_one_primary_owner(): void
    {
        $vehicle = Vehicle::factory()->create();

        $firstUser = User::query()->firstOrFail();

        VehicleOwner::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $firstUser->id,
            'is_primary' => true,
        ]);

        $secondUser = User::query()->create([
            'first_name' => 'Second',
            'last_name' => 'User',
            'mobile' => '01000000002',
            'email' => 'second@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.owners.store',
                $vehicle,
            ),
            [
                'user_id' => $secondUser->id,
                'ownership_type' => OwnershipType::OWNER->value,
                'is_primary' => true,
                'started_at' => now()->toDateString(),
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas(
            'vehicle_owners',
            [
                'user_id' => $secondUser->id,
                'is_primary' => true,
            ],
        );

        $this->assertDatabaseHas(
            'vehicle_owners',
            [
                'user_id' => $firstUser->id,
                'is_primary' => false,
            ],
        );
    }
}
