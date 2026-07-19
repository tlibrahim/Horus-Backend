<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleDocument;
use Modules\Vehicle\Models\VehicleDocumentType;

/**
 * @extends Factory<VehicleDocument>
 */
final class VehicleDocumentFactory extends Factory
{
    protected $model = VehicleDocument::class;

    public function definition(): array
    {
        $vehicle = Vehicle::query()->firstOrFail();

        $documentType = VehicleDocumentType::query()->firstOrFail();

        $fileName = fake()->uuid().'.pdf';

        return [
            'vehicle_id' => $vehicle->id,

            'document_type_id' => $documentType->id,

            'document_number' => fake()->bothify('DOC-#####'),

            'issue_date' => fake()->dateTimeBetween(
                '-3 years',
                '-1 month',
            ),

            'expiry_date' => fake()->dateTimeBetween(
                '+1 month',
                '+3 years',
            ),

            'file_name' => $fileName,

            'original_name' => fake()->words(2, true).'.pdf',

            'mime_type' => 'application/pdf',

            'size' => fake()->numberBetween(
                50 * 1024,
                5 * 1024 * 1024,
            ),

            'disk' => 'public',

            'path' => "vehicles/{$vehicle->id}/documents/{$fileName}",

            'metadata' => null,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (): array => [
            'expiry_date' => now()->subDay(),
        ]);
    }

    public function withoutExpiry(): static
    {
        return $this->state(fn (): array => [
            'expiry_date' => null,
        ]);
    }

    public function withoutNumber(): static
    {
        return $this->state(fn (): array => [
            'document_number' => null,
        ]);
    }
}
