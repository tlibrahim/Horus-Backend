<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleImage;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleImage;

interface VehicleImageServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): VehicleImage;

    public function create(Vehicle $vehicle, UploadedFile $image, array $attributes = []): VehicleImage;

    public function update(VehicleImage $image, array $attributes): VehicleImage;

    public function options(): Collection;

    public function delete(VehicleImage $image): bool;
}
