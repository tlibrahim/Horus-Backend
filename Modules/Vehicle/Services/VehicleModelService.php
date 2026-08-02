<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Vehicle\Contracts\VehicleModel\VehicleModelRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleModel\VehicleModelServiceInterface;
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
        Model $vehicleModel,
        array $attributes,
    ): Model {
        /** @var VehicleModel */
        return $this->updateFromRepository($vehicleModel, $attributes);
    }

    public function toggleStatus(
        Model $vehicleModel,
        bool $isActive,
    ): Model {
        /** @var VehicleModel */
        return $this->toggleStatusOnRepository($vehicleModel, $isActive);
    }

    public function activate(Model $vehicleModel): Model
    {
        /** @var VehicleModel */
        return $this->activateOnRepository($vehicleModel);
    }

    public function deactivate(Model $vehicleModel): Model
    {
        /** @var VehicleModel */
        return $this->deactivateOnRepository($vehicleModel);
    }

    public function delete(Model $vehicleModel): bool
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
