<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\CityRepositoryInterface;
use Modules\Core\Contracts\CityServiceInterface;
use Modules\Core\Filters\CityFilter;
use Modules\Core\Models\City;

final class CityService extends BaseService implements CityServiceInterface
{
    public function __construct(
        private readonly CityRepositoryInterface $cities,
    ) {}

    public function all(): Collection
    {
        return $this->cities->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->cities->paginate(
            perPage: $perPage,
            filter: new CityFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->cities->options();
    }

    public function find(int|string $id): City
    {
        /** @var City */
        return $this->cities->findOrFail($id);
    }

    public function create(array $attributes): City
    {
        /** @var City */
        return $this->transaction(
            fn () => $this->cities->create($attributes)
        );
    }

    public function update(
        City $city,
        array $attributes,
    ): City {
        /** @var City */
        return $this->transaction(
            fn () => $this->cities->update($city, $attributes)
        );
    }

    public function toggleStatus(
        City $city,
        bool $isActive,
    ): City {
        return $this->transaction(function () use ($city, $isActive) {
            /** @var City */
            return $this->cities->update($city, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(City $city): bool
    {
        return $this->transaction(
            fn () => $this->cities->delete($city)
        );
    }
}
