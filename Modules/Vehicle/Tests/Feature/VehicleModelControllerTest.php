<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Tests\TestCase;

final class VehicleModelControllerTest extends TestCase
{
    public function test_it_can_list_vehicle_models(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.models.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_store_vehicle_model(): void
    {
        $response = $this->postJson(
            route('api.v1.vehicle.models.store'),
            $this->validVehicleModelData([
                'name' => 'Sentra',
                'slug' => 'nissan-sentra',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('models', [
            'slug' => 'nissan-sentra',
            'name' => 'Sentra',
        ]);
    }

    public function test_it_validates_vehicle_model_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.vehicle.models.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, ['brand_id', 'name', 'slug']);
    }

    public function test_it_can_update_vehicle_model(): void
    {
        $vehicleModel = VehicleModel::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.models.update', $vehicleModel),
            $this->validVehicleModelData([
                'brand_id' => $vehicleModel->brand_id,
                'name' => 'Updated Model',
                'slug' => 'updated-model',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('models', [
            'id' => $vehicleModel->id,
            'name' => 'Updated Model',
            'slug' => 'updated-model',
        ]);
    }

    public function test_it_can_toggle_vehicle_model_status(): void
    {
        $vehicleModel = VehicleModel::query()->firstOrFail();

        $response = $this->patchJson(
            route('api.v1.vehicle.models.toggleStatus', $vehicleModel),
            ['is_active' => ! $vehicleModel->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('models', [
            'id' => $vehicleModel->id,
            'is_active' => ! $vehicleModel->is_active,
        ]);
    }

    public function test_it_can_delete_vehicle_model(): void
    {
        $vehicleModel = VehicleModel::query()->whereDoesntHave('generations')->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.vehicle.models.destroy', $vehicleModel),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('models', [
            'id' => $vehicleModel->id,
        ]);
    }
}
