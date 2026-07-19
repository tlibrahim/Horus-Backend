<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleDocument;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleDocument;

interface VehicleDocumentServiceInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): VehicleDocument;

    public function create(Vehicle $vehicle, UploadedFile $file, array $attributes): VehicleDocument;

    public function update(VehicleDocument $document, array $attributes): VehicleDocument;

    public function delete(VehicleDocument $document): bool;
}
