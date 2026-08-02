<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Vehicle\Contracts\Vehicle\VehicleRepositoryInterface;
use Modules\Vehicle\Contracts\Vehicle\VehicleServiceInterface;
use Modules\Vehicle\Models\Vehicle;

class VehicleService extends BaseCrudService implements VehicleServiceInterface
{
    public function __construct(
        private readonly VehicleRepositoryInterface $repository
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

    public function find(int|string $id): Vehicle
    {
        /** @var Vehicle */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Vehicle
    {
        /** @var Vehicle */
        return $this->createFromRepository($attributes);
    }

    public function update(Model $vehicle, array $attributes): Model
    {
        /** @var Vehicle */
        return $this->updateFromRepository($vehicle, $attributes);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function toggleStatus(Model $vehicle, bool $isActive): Model
    {
        /** @var Vehicle */
        return $this->toggleStatusFromRepository($vehicle, $isActive);
    }

    public function delete(Model $vehicle): bool
    {
        return $this->deleteFromRepository($vehicle);
    }
}
