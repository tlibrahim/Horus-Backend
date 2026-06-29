<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\DistrictRepositoryInterface;
use Modules\Core\Contracts\DistrictServiceInterface;
use Modules\Core\Filters\DistrictFilter;
use Modules\Core\Models\District;

final class DistrictService extends BaseService implements DistrictServiceInterface
{
    public function __construct(
        private readonly DistrictRepositoryInterface $districts,
    ) {}

    public function all(): Collection
    {
        return $this->districts->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->districts->paginate(
            perPage: $perPage,
            filter: new DistrictFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->districts->options();
    }

    public function find(int|string $id): District
    {
        /** @var District */
        return $this->districts->findOrFail($id);
    }

    public function create(array $attributes): District
    {
        /** @var District */
        return $this->transaction(
            fn () => $this->districts->create($attributes)
        );
    }

    public function update(
        District $district,
        array $attributes,
    ): District {
        /** @var District */
        return $this->transaction(
            fn () => $this->districts->update($district, $attributes)
        );
    }

    public function toggleStatus(
        District $district,
        bool $isActive,
    ): District {
        return $this->transaction(function () use ($district, $isActive) {
            /** @var District */
            return $this->districts->update($district, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(District $district): bool
    {
        return $this->transaction(
            fn () => $this->districts->delete($district)
        );
    }
}
