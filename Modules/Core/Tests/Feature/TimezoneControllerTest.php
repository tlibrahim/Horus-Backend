<?php

declare(strict_types=1);

namespace Modules\Core\Tests\Feature;

use Modules\Core\Models\Timezone;
use Modules\Core\Tests\TestCase;

final class TimezoneControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_can_list_timezones(): void
    {
        $response = $this->getJson(
            route('api.v1.core.timezones.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_return_timezone_options(): void
    {
        $response = $this->getJson(
            route('api.v1.core.timezones.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(
            0,
            count($response->json('data'))
        );
    }

    public function test_it_can_show_a_timezone(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $response = $this->getJson(
            route(
                'api.v1.core.timezones.show',
                $timezone
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $timezone->id,
        );
    }

    public function test_it_returns_not_found_for_unknown_timezone(): void
    {
        $response = $this->getJson(
            route(
                'api.v1.core.timezones.show',
                999999,
            ),
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }

    public function test_it_can_store_timezone(): void
    {
        $response = $this->postJson(
            route('api.v1.core.timezones.store'),
            $this->validTimezoneData([
                'name' => 'Pacific/Guam',
                'utc_offset' => '+10:00',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('timezones', [
            'name' => 'Pacific/Guam',
            'utc_offset' => '+10:00',
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.core.timezones.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'utc_offset',
        ]);
    }

    public function test_it_can_update_timezone(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $response = $this->putJson(
            route(
                'api.v1.core.timezones.update',
                $timezone
            ),
            $this->validTimezoneData([
                'name' => 'Updated Timezone Name',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('timezones', [
            'id' => $timezone->id,
            'name' => 'Updated Timezone Name',
        ]);
    }

    public function test_it_validates_update_request(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.core.timezones.update', $timezone),
            [
                'name' => '',
            ],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'name',
            'utc_offset',
        ]);
    }

    public function test_it_can_toggle_timezone_status(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $response = $this->patchJson(
            route(
                'api.v1.core.timezones.toggleStatus',
                $timezone
            ),
            ['is_active' => ! $timezone->is_active],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('timezones', [
            'id' => $timezone->id,
            'is_active' => ! $timezone->is_active,
        ]);
    }

    public function test_it_can_activate_timezone(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $timezone->update([
            'is_active' => false,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.timezones.toggleStatus', $timezone),
            [
                'is_active' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('timezones', [
            'id' => $timezone->id,
            'is_active' => true,
        ]);
    }

    public function test_it_can_deactivate_timezone(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $timezone->update([
            'is_active' => true,
        ]);

        $response = $this->patchJson(
            route('api.v1.core.timezones.toggleStatus', $timezone),
            [
                'is_active' => false,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('timezones', [
            'id' => $timezone->id,
            'is_active' => false,
        ]);
    }

    public function test_it_can_delete_timezone(): void
    {
        $timezone = Timezone::query()->firstOrFail();

        $response = $this->deleteJson(
            route('api.v1.core.timezones.destroy', $timezone),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('timezones', [
            'id' => $timezone->id,
        ]);
    }

    public function test_it_returns_404_when_deleting_unknown_timezone(): void
    {
        $response = $this->deleteJson(
            route('api.v1.core.timezones.destroy', 999999),
            [],
            $this->apiHeaders(),
        );

        $response->assertNotFound();
    }
}
