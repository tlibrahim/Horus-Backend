<?php

declare(strict_types=1);

namespace Modules\OBD\Tests\Feature;

use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Tests\TestCase;

final class ObdDeviceControllerTest extends TestCase
{
    public function test_it_can_list_obd_devices(): void
    {
        ObdDevice::factory()->count(3)->create();
        $response = $this->getJson(
            route('api.v1.obd.devices.index'),
            $this->apiHeaders(),
        );

        $this->assertPaginatedResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_return_obd_device_options(): void
    {
        ObdDevice::factory()->count(3)->create();
        $response = $this->getJson(
            route('api.v1.obd.devices.options'),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $this->assertGreaterThan(0, count($response->json('data')));
    }

    public function test_it_can_show_an_obd_device(): void
    {
        $device = ObdDevice::factory()->create();

        $response = $this->getJson(
            route('api.v1.obd.devices.show', $device),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
        $response->assertJsonPath('data.id', $device->id);
    }

    public function test_it_can_store_obd_device(): void
    {
        $response = $this->postJson(
            route('api.v1.obd.devices.store'),
            $this->validObdDeviceData([
                'serial_number' => 'OBD-TEST-000001',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('obd_devices', [
            'serial_number' => 'OBD-TEST-000001',
        ]);
    }

    public function test_it_validates_obd_device_store_request(): void
    {
        $response = $this->postJson(
            route('api.v1.obd.devices.store'),
            [],
            $this->apiHeaders(),
        );

        $this->assertValidationResponse($response, [
            'serial_number',
            'manufacturer',
            'model',
            'connection_type',
        ]);
    }

    public function test_it_can_update_obd_device(): void
    {
        $device = ObdDevice::factory()->create();

        $response = $this->putJson(
            route('api.v1.obd.devices.update', $device),
            $this->validObdDeviceData([
                'manufacturer' => 'Updated Manufacturer',
                'model' => 'Updated Model',
            ]),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('obd_devices', [
            'id' => $device->id,
            'manufacturer' => 'Updated Manufacturer',
            'model' => 'Updated Model',
        ]);
    }

    public function test_it_can_toggle_obd_device_status(): void
    {
        $device = ObdDevice::factory()->create();

        $newStatus = $device->status->value === 'active';

        $response = $this->patchJson(
            route('api.v1.obd.devices.toggleStatus', $device),
            [
                'is_active' => ! $newStatus,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);
    }

    public function test_it_can_delete_obd_device(): void
    {
        $device = ObdDevice::factory()->create();

        $response = $this->deleteJson(
            route('api.v1.obd.devices.destroy', $device),
            [],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertSoftDeleted('obd_devices', [
            'id' => $device->id,
        ]);
    }
}
