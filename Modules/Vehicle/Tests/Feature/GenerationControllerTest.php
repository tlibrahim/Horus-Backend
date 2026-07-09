<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Tests\TestCase;

final class GenerationControllerTest extends TestCase
{
    public function test_it_can_list_generations(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.generations.index'), $this->apiHeaders());

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_store_generation(): void
    {
        $model = VehicleModel::query()->firstOrFail();

        $response = $this->postJson(
            route('api.v1.vehicle.generations.store'),
            [
                'model_id' => $model->id,
                'name' => 'Test Gen',
                'start_year' => 2020,
                'end_year' => 2024,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);
        $this->assertDatabaseHas('generations', ['model_id' => $model->id, 'name' => 'Test Gen']);
    }

    public function test_it_can_update_generation(): void
    {
        $generation = Generation::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.generations.update', $generation),
            [
                'model_id' => $generation->model_id,
                'name' => 'Updated Generation',
                'start_year' => $generation->start_year,
                'end_year' => $generation->end_year,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertDatabaseHas('generations', ['id' => $generation->id, 'name' => 'Updated Generation']);
    }
}
