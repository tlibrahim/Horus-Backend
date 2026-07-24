<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\OBD;

use Modules\Vehicle\Models\ObdSession;
use Modules\Vehicle\Models\VehicleObdDevice;
use Modules\Vehicle\Tests\TestCase;

final class ObdSessionControllerTest extends TestCase
{
    public function test_it_can_list_obd_sessions(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.obd-sessions.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);

        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_return_obd_session_options(): void
    {
        $response = $this->getJson(
            route('api.v1.vehicle.obd-sessions.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_obd_session(): void
    {
        $session = ObdSession::query()->firstOrFail();

        $response = $this->getJson(
            route('api.v1.vehicle.obd-sessions.show', $session),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath('data.id', $session->id);
    }

    public function test_it_can_store_obd_session(): void
    {
        $pairing = VehicleObdDevice::query()->firstOrFail();

        $response = $this->postJson(
            route('api.v1.vehicle.obd-sessions.store'),
            $this->validObdSessionData([
                'vehicle_obd_device_id' => $pairing->id,
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('obd_sessions', [
            'vehicle_obd_device_id' => $pairing->id,
        ]);
    }

    public function test_it_validates_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.vehicle.obd-sessions.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'vehicle_obd_device_id',
            'connection_type',
        ]);
    }

    public function test_it_can_update_obd_session(): void
    {
        $session = ObdSession::query()->firstOrFail();

        $response = $this->putJson(
            route('api.v1.vehicle.obd-sessions.update', $session),
            [
                'status' => 'connected',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('obd_sessions', [
            'id' => $session->id,
            'status' => 'connected',
        ]);
    }

    public function test_it_can_delete_obd_session(): void
    {
        $session = ObdSession::factory()->create();

        $response = $this->deleteJson(
            route('api.v1.vehicle.obd-sessions.destroy', $session),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseMissing('obd_sessions', [
            'id' => $session->id,
        ]);
    }
}
