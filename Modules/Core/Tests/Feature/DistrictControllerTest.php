<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\District;
use Modules\Core\Tests\TestCase;

final class DistrictControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_districts(): void
    {
        $response = $this->getJson(
            route('api.v1.core.districts.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_district_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.districts.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_district(): void
    {
        $district = District::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.districts.show',
                $district
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $district->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_district(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.districts.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_district(): void
    {
        $response = $this->postJson(
            route('api.v1.core.districts.store'),
            $this->validDistrictData([
                'name' => 'Test District',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('districts', [
            'name' => 'Test District',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.districts.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'city_id',
            'name',
        ]);
    }

    public function test_it_can_update_district(): void
    {
        $district = District::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.districts.update',
                $district
            ),
            $this->validDistrictData([
                'name' => 'Updated District Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'name' => 'Updated District Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $district = District::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.districts.update', $district),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'city_id',
            'name',
        ]);
    }

    public function test_it_can_toggle_district_status(): void
    {
        $district = District::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.districts.toggleStatus',
                $district
            ),
            ['is_active' => ! $district->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'is_active' => ! $district->is_active,
        ]);
    }

    public function test_it_can_activate_district(): void
    {
        $district = District::query()->firstOrFail();

        $district->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.districts.toggleStatus', $district),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_district(): void
    {
        $district = District::query()->firstOrFail();

        $district->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.districts.toggleStatus', $district),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_district(): void
    {
        $district = District::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.districts.destroy', $district),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('districts', [
            'id' => $district->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_district(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.districts.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
