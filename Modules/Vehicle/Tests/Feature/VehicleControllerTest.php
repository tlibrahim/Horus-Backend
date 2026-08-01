<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Auth\Models\User;
use Modules\Vehicle\Models\BodyType;
use Modules\Vehicle\Models\DriveType;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleType;
use Modules\Vehicle\Tests\TestCase;

final class VehicleControllerTest extends TestCase
{
    public function test_it_can_list_vehicles(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.vehicles.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_vehicle(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $response = $this->getJson(
            route('api.v1.vehicle.vehicles.show', $vehicle),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertEquals(
            $vehicle->id,
            $response->json('data.id')
        );
    }

    public function test_it_can_get_vehicle_options(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.vehicles.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_store_vehicle(): void
    {
        $user = User::query()->firstOrFail();

        $engine = Engine::query()
            ->with('generation.model.brand')
            ->firstOrFail();

        $generation = $engine->generation;

        $model = $generation->model;

        $brand = $model->brand;

        $bodyType = BodyType::query()->firstOrFail();

        $driveType = DriveType::query()->firstOrFail();

        $vehicleType = VehicleType::query()->firstOrFail();

        $response = $this->postJson(
            route('api.v1.vehicle.vehicles.store'),
            [
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'model_id' => $model->id,
                'generation_id' => $generation->id,
                'engine_id' => $engine->id,
                'body_type_id' => $bodyType->id,
                'drive_type_id' => $driveType->id,
                'vehicle_type_id' => $vehicleType->id,
                'vin' => 'TESTVIN1234567890',
                'plate_number' => 'ABC123',
                'manufacture_year' => 2024,
                'current_mileage' => 1500,
                'color' => 'Black',
                'is_primary' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('vehicles', [
            'vin' => 'TESTVIN1234567890',
        ]);
    }

    public function test_it_can_update_vehicle(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.vehicles.update', $vehicle),
            [
                'user_id' => $vehicle->user_id,
                'brand_id' => $vehicle->brand_id,
                'model_id' => $vehicle->model_id,
                'generation_id' => $vehicle->generation_id,
                'engine_id' => $vehicle->engine_id,
                'body_type_id' => $vehicle->body_type_id,
                'drive_type_id' => $vehicle->drive_type_id,
                'vehicle_type_id' => $vehicle->vehicle_type_id,
                'vin' => $vehicle->vin,
                'plate_number' => 'NEW-999',
                'manufacture_year' => $vehicle->manufacture_year,
                'current_mileage' => 50000,
                'color' => 'Blue',
                'is_primary' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'plate_number' => 'NEW-999',
            'color' => 'Blue',
        ]);
    }

    public function test_it_can_delete_vehicle(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.vehicle.vehicles.destroy', $vehicle),
            [],
            $this->apiHeaders(),
        );
        $response->assertNoContent();

        $this->assertSoftDeleted('vehicles', [
            'id' => $vehicle->id,
        ]);
    }
}
