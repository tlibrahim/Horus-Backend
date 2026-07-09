<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\VehicleModelRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleModelServiceInterface;
use Modules\Vehicle\Filters\VehicleModelFilter;
use Modules\Vehicle\Models\VehicleModel;

final class VehicleModelService extends BaseCrudService implements VehicleModelServiceInterface
{
    public function __construct(
        private readonly VehicleModelRepositoryInterface $vehicleModels,
    ) {}

    public function all(): Collection
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

    public function find(int|string $id): VehicleModel
    {
        /** @var VehicleModel */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): VehicleModel
    {
        /** @var VehicleModel */
        return $this->createFromRepository($attributes);
    }

    public function update(
        VehicleModel $vehicleModel,
        array $attributes,
    ): VehicleModel {
        /** @var VehicleModel */
        return $this->updateFromRepository($vehicleModel, $attributes);
    }

    public function toggleStatus(
        VehicleModel $vehicleModel,
        bool $isActive,
    ): VehicleModel {
        /** @var VehicleModel */
        return $this->toggleStatusOnRepository($vehicleModel, $isActive);
    }

    public function delete(VehicleModel $vehicleModel): bool
    {
        return $this->deleteFromRepository($vehicleModel);
    }

    protected function repository(): VehicleModelRepositoryInterface
    {
        return $this->vehicleModels;
    }

    protected function filterClass(): ?string
    {
        return VehicleModelFilter::class;
    }
}
