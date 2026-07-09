<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\FuelType;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\Transmission;
use Modules\Vehicle\Tests\TestCase;

final class EngineControllerTest extends TestCase
{
    public function test_it_can_list_engines(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.engines.index'), $this->apiHeaders());

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_store_engine(): void
    {
        $generation = Generation::query()->firstOrFail();
        $fuelType = FuelType::query()->firstOrFail();
        $transmission = Transmission::query()->firstOrFail();

        $response = $this->postJson(
            route('api.v1.vehicle.engines.store'),
            [
                'generation_id' => $generation->id,
                'code' => 'TEST-ENG-1',
                'name' => 'Test Engine',
                'displacement' => 1.6,
                'horse_power' => 120,
                'torque' => 190,
                'fuel_type_id' => $fuelType->id,
                'transmission_id' => $transmission->id,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);
        $this->assertDatabaseHas('engines', ['code' => 'TEST-ENG-1']);
    }

    public function test_it_can_update_engine(): void
    {
        $engine = Engine::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.engines.update', $engine),
            [
                'generation_id' => $engine->generation_id,
                'code' => $engine->code,
                'name' => 'Updated Engine Name',
                'displacement' => $engine->displacement,
                'horse_power' => $engine->horse_power,
                'torque' => $engine->torque,
                'fuel_type_id' => $engine->fuel_type_id,
                'transmission_id' => $engine->transmission_id,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertDatabaseHas('engines', ['id' => $engine->id, 'name' => 'Updated Engine Name']);
    }
}
