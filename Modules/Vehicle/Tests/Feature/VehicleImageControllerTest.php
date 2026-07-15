<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleImage;
use Modules\Vehicle\Tests\TestCase;

final class VehicleImageControllerTest extends TestCase
{
    public function test_it_can_list_vehicle_images(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        VehicleImage::factory()->count(3)->create([
            'vehicle_id' => $vehicle->id,
        ]);

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicles.images.index',
                $vehicle
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertCount(
            3,
            $response->json('data')
        );
    }

    public function test_it_can_upload_vehicle_image(): void
    {
        Storage::fake('public');
        config()->set('filesystems.default', 'public');

        $vehicle = Vehicle::query()->firstOrFail();

        // $image = UploadedFile::fake()->image('vehicle.jpg');
        $image = UploadedFile::fake()->create(
            'vehicle.jpg',
            200, // KB
            'image/jpeg',
        );

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.images.store',
                $vehicle
            ),
            [
                'image' => $image,
                'is_primary' => true,
                'sort_order' => 1,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('vehicle_images', [
            'vehicle_id' => $vehicle->id,
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        $vehicleImage = VehicleImage::query()->firstOrFail();

        Storage::disk($vehicleImage->disk)
            ->assertExists($vehicleImage->path);
    }

    public function test_it_can_show_vehicle_image(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $image = VehicleImage::query()->create([
            'vehicle_id' => $vehicle->id,
            'disk' => 'public',
            'path' => 'vehicles/test/image.jpg',
            'thumbnail_path' => null,
            'original_name' => 'image.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
            'sort_order' => 1,
            'is_primary' => false,
        ]);

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicle-images.show',
                $image
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $image->id,
        );
    }

    public function test_it_can_update_vehicle_image(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $image = VehicleImage::query()->create([
            'vehicle_id' => $vehicle->id,
            'disk' => 'public',
            'path' => 'vehicles/test/image.jpg',
            'thumbnail_path' => null,
            'original_name' => 'image.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
            'sort_order' => 1,
            'is_primary' => false,
        ]);

        $response = $this->patchJson(
            route(
                'api.v1.vehicle.vehicle-images.update',
                $image
            ),
            [
                'sort_order' => 99,
                'is_primary' => true,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('vehicle_images', [
            'id' => $image->id,
            'sort_order' => 99,
            'is_primary' => true,
        ]);
    }

    public function test_it_can_delete_vehicle_image(): void
    {
        Storage::fake('public');

        $vehicle = Vehicle::query()->firstOrFail();

        Storage::disk('public')->put(
            'vehicles/test/delete.jpg',
            'fake-image-content'
        );

        $image = VehicleImage::query()->create([
            'vehicle_id' => $vehicle->id,
            'disk' => 'public',
            'path' => 'vehicles/test/delete.jpg',
            'thumbnail_path' => null,
            'original_name' => 'delete.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 18,
            'sort_order' => 1,
            'is_primary' => false,
        ]);
        $response = $this->deleteJson(
            route(
                'api.v1.vehicle.vehicle-images.destroy',
                $image
            ),
            [],
            $this->apiHeaders(),
        );

        $response->assertNoContent();

        $this->assertSoftDeleted(
            'vehicle_images',
            [
                'id' => $image->id,
            ]
        );

        Storage::disk('public')
            ->assertMissing('vehicles/test/delete.jpg');
    }

    public function test_it_validates_upload_request(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.images.store',
                $vehicle
            ),
            [],
            $this->apiHeaders(),
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error' => [
                    'status' => 422,
                ],
            ])
            ->assertJsonPath(
                'error.errors.image.0',
                'The image field is required.'
            );
    }
}
