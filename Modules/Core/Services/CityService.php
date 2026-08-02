<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        Model $city,
        array $attributes,
    ): Model {
        /** @var City */
        return $this->transaction(
            fn () => $this->cities->update($city, $attributes)
        );
    }

    public function toggleStatus(Model $city, bool $isActive): Model
    {
        return $this->transaction(function () use ($city, $isActive): Model {
            /** @var City */
            return $this->cities->update($city, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function activate(Model $city): Model
    {
        return $this->toggleStatus($city, true);
    }

    public function deactivate(Model $city): Model
    {
        return $this->toggleStatus($city, false);
    }

    public function delete(Model $city): bool
    {
        return $this->transaction(
            fn () => $this->cities->delete($city)
        );
    }
}
