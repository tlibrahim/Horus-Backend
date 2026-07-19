<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Contracts\FileStorageServiceInterface;
use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentServiceInterface;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleDocument;

final class VehicleDocumentService extends BaseCrudService implements VehicleDocumentServiceInterface
{
    public function __construct(
        private readonly VehicleDocumentRepositoryInterface $repository,
        private readonly FileStorageServiceInterface $storage,
    ) {}

    protected function repository(): CrudRepositoryInterface
    {
        return $this->repository;
    }

    public function all(): iterable
    {
        return $this->allFromRepository();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(int|string $id): VehicleDocument
    {
        /** @var VehicleDocument */
        return $this->findFromRepository($id);
    }

    public function create(
        Vehicle $vehicle,
        UploadedFile $file,
        array $attributes = [],
    ): VehicleDocument {
        return $this->transaction(function () use (
            $vehicle,
            $file,
            $attributes,
        ) {

            $storedFile = $this->storage->store(
                file: $file,
                directory: "vehicles/{$vehicle->id}/documents",
            );

            /** @var VehicleDocument */
            return $this->createFromRepository([
                'vehicle_id' => $vehicle->id,

                'document_type_id' => $attributes['document_type_id'],

                'document_number' => $attributes['document_number'] ?? null,

                'issue_date' => $attributes['issue_date'] ?? null,

                'expiry_date' => $attributes['expiry_date'] ?? null,

                'file_name' => basename($storedFile['path']),

                'original_name' => $storedFile['original_name'],

                'mime_type' => $storedFile['mime_type'],

                'size' => $storedFile['size'],

                'disk' => $storedFile['disk'],

                'path' => $storedFile['path'],

                'metadata' => null,
            ]);
        });
    }

    public function update(
        VehicleDocument $document,
        array $attributes,
    ): VehicleDocument {
        /** @var VehicleDocument */
        return $this->updateFromRepository(
            $document,
            $attributes,
        );
    }

    public function delete(
        VehicleDocument $document,
    ): bool {
        return $this->transaction(function () use ($document) {

            $this->storage->delete(
                path: $document->path,
                disk: $document->disk,
            );

            return $this->deleteFromRepository($document);
        });
    }
}
