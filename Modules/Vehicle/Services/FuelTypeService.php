<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\FuelType\FuelTypeRepositoryInterface;
use Modules\Vehicle\Contracts\FuelType\FuelTypeServiceInterface;
use Modules\Vehicle\Filters\FuelTypeFilter;
use Modules\Vehicle\Models\FuelType;

final class FuelTypeService extends BaseService implements FuelTypeServiceInterface
{
    public function __construct(
        private readonly FuelTypeRepositoryInterface $fuelTypes,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->fuelTypes->paginate(
            perPage: $perPage,
            filter: new FuelTypeFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->fuelTypes->options();
    }

    public function find(int|string $id): FuelType
    {
        /** @var FuelType */
        return $this->fuelTypes->findOrFail($id);
    }
}
