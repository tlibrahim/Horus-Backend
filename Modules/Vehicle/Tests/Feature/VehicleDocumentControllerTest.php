<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleDocument;
use Modules\Vehicle\Models\VehicleDocumentType;
use Modules\Vehicle\Tests\TestCase;

final class VehicleDocumentControllerTest extends TestCase
{
    public function test_it_can_list_vehicle_documents(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $type = VehicleDocumentType::query()->firstOrFail();

        VehicleDocument::factory()
            ->count(3)
            ->create([
                'vehicle_id' => $vehicle->id,
                'document_type_id' => $type->id,
            ]);

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicles.documents.index',
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

    public function test_it_can_upload_vehicle_document(): void
    {
        Storage::fake('public');

        config()->set('filesystems.default', 'public');

        $vehicle = Vehicle::query()->firstOrFail();

        $type = VehicleDocumentType::query()->firstOrFail();

        $file = UploadedFile::fake()->create(
            'insurance.pdf',
            200,
            'application/pdf',
        );

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.documents.store',
                $vehicle,
            ),
            [
                'document_type_id' => $type->id,
                'document_number' => 'INS-001',
                'issue_date' => now()->toDateString(),
                'expiry_date' => now()->addYear()->toDateString(),
                'file' => $file,
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response, 201);

        $this->assertDatabaseHas('vehicle_documents', [
            'vehicle_id' => $vehicle->id,
            'document_type_id' => $type->id,
            'document_number' => 'INS-001',
        ]);

        $document = VehicleDocument::query()->firstOrFail();

        Storage::disk($document->disk)
            ->assertExists($document->path);
    }

    public function test_it_can_show_vehicle_document(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $type = VehicleDocumentType::query()->firstOrFail();

        $document = VehicleDocument::factory()->create([
            'vehicle_id' => $vehicle->id,
            'document_type_id' => $type->id,
        ]);

        $response = $this->getJson(
            route(
                'api.v1.vehicle.vehicle-documents.show',
                $document,
            ),
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $response->assertJsonPath(
            'data.id',
            $document->id,
        );

        $response->assertJsonPath(
            'data.document_number',
            $document->document_number,
        );
    }

    public function test_it_can_update_vehicle_document(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $type = VehicleDocumentType::query()->firstOrFail();

        $document = VehicleDocument::factory()->create([
            'vehicle_id' => $vehicle->id,
            'document_type_id' => $type->id,
        ]);

        $response = $this->patchJson(
            route(
                'api.v1.vehicle.vehicle-documents.update',
                $document,
            ),
            [
                'document_number' => 'NEW-001',
                'expiry_date' => now()->addYears(2)->toDateString(),
            ],
            $this->apiHeaders(),
        );

        $this->assertSuccessResponse($response);

        $this->assertDatabaseHas('vehicle_documents', [
            'id' => $document->id,
            'document_number' => 'NEW-001',
        ]);
    }

    public function test_it_can_delete_vehicle_document(): void
    {
        Storage::fake('public');

        $vehicle = Vehicle::query()->firstOrFail();

        $type = VehicleDocumentType::query()->firstOrFail();

        Storage::disk('public')->put(
            'vehicles/test/document.pdf',
            'fake pdf',
        );

        $document = VehicleDocument::factory()->create([
            'vehicle_id' => $vehicle->id,
            'document_type_id' => $type->id,
            'disk' => 'public',
            'path' => 'vehicles/test/document.pdf',
            'file_name' => 'document.pdf',
        ]);

        $response = $this->deleteJson(
            route(
                'api.v1.vehicle.vehicle-documents.destroy',
                $document,
            ),
            [],
            $this->apiHeaders(),
        );

        $response->assertNoContent();

        $this->assertDatabaseMissing(
            'vehicle_documents',
            [
                'id' => $document->id,
            ],
        );

        Storage::disk('public')
            ->assertMissing('vehicles/test/document.pdf');
    }

    public function test_it_validates_upload_request(): void
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $response = $this->postJson(
            route(
                'api.v1.vehicle.vehicles.documents.store',
                $vehicle,
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
                'error.errors.file.0',
                'The file field is required.',
            );
    }
}
