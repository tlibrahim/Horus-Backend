<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\VehicleType\VehicleTypeRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleType\VehicleTypeServiceInterface;
use Modules\Vehicle\Filters\VehicleTypeFilter;
use Modules\Vehicle\Models\VehicleType;

final class VehicleTypeService extends BaseService implements VehicleTypeServiceInterface
{
    public function __construct(
        private readonly VehicleTypeRepositoryInterface $vehicleTypes,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->vehicleTypes->paginate(
            perPage: $perPage,
            filter: new VehicleTypeFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->vehicleTypes->options();
    }

    public function find(int|string $id): VehicleType
    {
        /** @var VehicleType */
        return $this->vehicleTypes->findOrFail($id);
    }
}
