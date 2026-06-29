<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\City;
use Modules\Core\Tests\TestCase;

final class CityControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_cities(): void
    {
        $response = $this->getJson(
            route('api.v1.core.cities.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_city_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.cities.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_city(): void
    {
        $city = City::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.cities.show',
                $city
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $city->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_city(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.cities.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_city(): void
    {
        $response = $this->postJson(
            route('api.v1.core.cities.store'),
            $this->validCityData([
                'name' => 'Test City',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('cities', [
            'name' => 'Test City',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.cities.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'country_id',
            'name',
        ]);
    }

    public function test_it_can_update_city(): void
    {
        $city = City::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.cities.update',
                $city
            ),
            $this->validCityData([
                'name' => 'Updated City Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => 'Updated City Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $city = City::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.cities.update', $city),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'country_id',
            'name',
        ]);
    }

    public function test_it_can_toggle_city_status(): void
    {
        $city = City::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.cities.toggleStatus',
                $city
            ),
            ['is_active' => ! $city->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'is_active' => ! $city->is_active,
        ]);
    }

    public function test_it_can_activate_city(): void
    {
        $city = City::query()->firstOrFail();

        $city->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.cities.toggleStatus', $city),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_city(): void
    {
        $city = City::query()->firstOrFail();

        $city->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.cities.toggleStatus', $city),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_city(): void
    {
        $city = City::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.cities.destroy', $city),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('cities', [
            'id' => $city->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_city(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.cities.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
