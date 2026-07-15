<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Contracts\FileStorageServiceInterface;
use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageServiceInterface;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class VehicleImageService extends BaseCrudService implements VehicleImageServiceInterface
{
    public function __construct(
        private readonly VehicleImageRepositoryInterface $repository,
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

    public function find(int|string $id): VehicleImage
    {
        return $this->findFromRepository($id);
    }

    public function create(Vehicle $vehicle, UploadedFile $image, array $attributes = []): VehicleImage
    {
        return $this->transaction(function () use ($vehicle, $image, $attributes) {

            $file = $this->storage->store(
                file: $image,
                directory: "vehicles/{$vehicle->id}",
            );

            return $this->repository->create([
                'vehicle_id' => $vehicle->id,

                'disk' => $file['disk'],

                'path' => $file['path'],

                'thumbnail_path' => null,

                'original_name' => $file['original_name'],

                'mime_type' => $file['mime_type'],

                'size' => $file['size'],

                'sort_order' => $attributes['sort_order'] ?? 0,

                'is_primary' => $attributes['is_primary'] ?? false,
            ]);
        });
    }

    public function update(VehicleImage $image, array $attributes): VehicleImage
    {
        return $this->transaction(function () use ($image, $attributes) {

            if (($attributes['is_primary'] ?? false) === true) {

                $image->vehicle
                    ->images()
                    ->whereKeyNot($image->id)
                    ->update([
                        'is_primary' => false,
                    ]);
            }

            return $this->updateFromRepository(
                $image,
                $attributes,
            );
        });
    }

    public function delete(VehicleImage $image): bool
    {
        return $this->transaction(function () use ($image) {

            $this->storage->delete(
                path: $image->path,
                disk: $image->disk,
            );

            if ($image->thumbnail_path !== null) {
                $this->storage->delete(
                    path: $image->thumbnail_path,
                    disk: $image->disk,
                );
            }

            return $this->repository->delete($image);
        });

        // return $this->deleteFromRepository($image);
    }
}
