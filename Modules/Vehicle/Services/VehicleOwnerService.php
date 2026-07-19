<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\VehicleOwner\VehicleOwnerRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleOwner\VehicleOwnerServiceInterface;
use Modules\Vehicle\Enums\OwnershipType;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;

final class VehicleOwnerService extends BaseCrudService implements VehicleOwnerServiceInterface
{
    public function __construct(
        private readonly VehicleOwnerRepositoryInterface $repository,
    ) {}

    protected function repository(): CrudRepositoryInterface
    {
        return $this->repository;
    }

    public function all(): iterable
    {
        return $this->allFromRepository();
    }

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(
        int|string $id,
    ): VehicleOwner {
        /** @var VehicleOwner */
        return $this->findFromRepository($id);
    }

    public function create(
        Vehicle $vehicle,
        array $attributes,
    ): VehicleOwner {
        return $this->transaction(function () use (
            $vehicle,
            $attributes,
        ) {
            if (($attributes['is_primary'] ?? false) === true) {
                $this->clearPrimaryOwner($vehicle);
            }

            /** @var VehicleOwner */
            return $this->createFromRepository([
                'vehicle_id' => $vehicle->id,
                'user_id' => $attributes['user_id'],
                'ownership_type' => $attributes['ownership_type'] ?? OwnershipType::OWNER->value,
                'is_primary' => $attributes['is_primary'] ?? false,
                'ownership_percentage' => $attributes['ownership_percentage'] ?? 100,
                'started_at' => $attributes['started_at'] ?? now(),
                'ended_at' => $attributes['ended_at'] ?? null,
                'notes' => $attributes['notes'] ?? null,
            ]);
        });
    }

    public function update(
        VehicleOwner $ownership,
        array $attributes,
    ): VehicleOwner {
        return $this->transaction(function () use (
            $ownership,
            $attributes,
        ) {
            if (($attributes['is_primary'] ?? false) === true) {
                $this->clearPrimaryOwner($ownership->vehicle);
            }

            /** @var VehicleOwner */
            return $this->updateFromRepository(
                $ownership,
                $attributes,
            );
        });
    }

    public function delete(
        VehicleOwner $ownership,
    ): bool {
        return $this->deleteFromRepository($ownership);
    }

    public function byVehicle(
        Vehicle $vehicle,
    ): Collection {
        return $this->repository->byVehicle($vehicle);
    }

    public function primary(
        Vehicle $vehicle,
    ): ?VehicleOwner {
        return $this->repository->primary($vehicle);
    }

    public function active(
        Vehicle $vehicle,
    ): Collection {
        return $this->repository->active($vehicle);
    }

    private function clearPrimaryOwner(
        Vehicle $vehicle,
    ): void {
        VehicleOwner::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('is_primary', true)
            ->update([
                'is_primary' => false,
            ]);
    }
}
