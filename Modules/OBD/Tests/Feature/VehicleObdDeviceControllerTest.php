<?php

declare(strict_types=1);

namespace Modules\OBD\Tests\Feature;

use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\OBD\Tests\TestCase;
use Modules\Vehicle\Models\Vehicle;

final class VehicleObdDeviceControllerTest extends TestCase
{
    public function test_it_can_pair_obd_device(): void
    {
        $vehicle = Vehicle::factory()->create();

        $device = ObdDevice::factory()->create();

        $response = $this->postJson(
            route(
                'api.v1.obd.vehicles.devices.pair',
                $vehicle,
            ),
            [
                'obd_device_id' => $device->id,
                'notes' => 'Initial pairing',
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('vehicle_obd_devices', [
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $device->id,
            'is_active' => true,
        ]);
    }

    public function test_it_validates_pair_request(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->postJson(
            route(
                'api.v1.obd.vehicles.devices.pair',
                $vehicle,
            ),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse(
            $response,
            ['obd_device_id'],
        );
    }

    public function test_it_can_return_current_pairing(): void
    {
        $vehicle = Vehicle::factory()->create();

        $pairing = VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicle->id,
            'is_active' => true,
        ]);

        $response = $this->getJson(
            route(
                'api.v1.obd.vehicles.devices.current',
                $vehicle,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $pairing->id,
        );
    }

    public function test_current_returns_null_when_no_pairing_exists(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->getJson(
            route(
                'api.v1.obd.vehicles.devices.current',
                $vehicle,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJson([
            'data' => null,
        ]);
    }

    public function test_it_can_return_pairing_history(): void
    {
        $vehicle = Vehicle::factory()->create();

        VehicleObdDevice::factory()
            ->count(3)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route(
                'api.v1.obd.vehicles.devices.history',
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

    public function test_history_is_ordered_by_latest_pairing(): void
    {
        $vehicle = Vehicle::factory()->create();

        VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicle->id,
            'paired_at' => now()->subDays(5),
        ]);

        $latest = VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicle->id,
            'paired_at' => now(),
        ]);

        $response = $this->getJson(
            route(
                'api.v1.obd.vehicles.devices.history',
                $vehicle,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.0.id',
            $latest->id,
        );
    }

    public function test_it_can_unpair_obd_device(): void
    {
        $vehicle = Vehicle::factory()->create();

        $device = ObdDevice::factory()->create();

        VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $device->id,
            'is_active' => true,
        ]);

        $response = $this->deleteJson(
            route(
                'api.v1.obd.vehicles.devices.unpair',
                [
                    'vehicle' => $vehicle,
                    'obdDevice' => $device,
                ],
            ),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('vehicle_obd_devices', [
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $device->id,
            'is_active' => false,
        ]);
    }

    public function test_it_cannot_pair_device_that_is_already_paired(): void
    {
        $vehicleOne = Vehicle::factory()->create();

        $vehicleTwo = Vehicle::factory()->create();

        $device = ObdDevice::factory()->create();

        VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicleOne->id,
            'obd_device_id' => $device->id,
            'is_active' => true,
        ]);

        $response = $this->postJson(
            route(
                'api.v1.obd.vehicles.devices.pair',
                $vehicleTwo,
            ),
            [
                'obd_device_id' => $device->id,
            ],
            $this->apiHeaders(),
        );

        $response->assertStatus(409);
    }

    public function test_pairing_new_device_deactivates_previous_pairing(): void
    {
        $vehicle = Vehicle::factory()->create();

        $deviceOne = ObdDevice::factory()->create();

        $deviceTwo = ObdDevice::factory()->create();

        VehicleObdDevice::factory()->create([
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $deviceOne->id,
            'is_active' => true,
        ]);

        $response = $this->postJson(
            route(
                'api.v1.obd.vehicles.devices.pair',
                $vehicle,
            ),
            [
                'obd_device_id' => $deviceTwo->id,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('vehicle_obd_devices', [
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $deviceOne->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('vehicle_obd_devices', [
            'vehicle_id' => $vehicle->id,
            'obd_device_id' => $deviceTwo->id,
            'is_active' => true,
        ]);
    }

    public function test_it_cannot_unpair_non_active_pairing(): void
    {
        $vehicle = Vehicle::factory()->create();

        $device = ObdDevice::factory()->create();

        $response = $this->deleteJson(
            route(
                'api.v1.obd.vehicles.devices.unpair',
                [
                    'vehicle' => $vehicle,
                    'obdDevice' => $device,
                ],
            ),
            [],
            $this->apiHeaders(),
        );

        $response->assertStatus(409);
    }
}
