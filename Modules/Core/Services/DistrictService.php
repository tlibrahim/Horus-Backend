<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        Model $district,
        array $attributes,
    ): Model {
        /** @var District */
        return $this->transaction(
            fn () => $this->districts->update($district, $attributes)
        );
    }

    public function toggleStatus(Model $district, bool $isActive): Model
    {
        return $this->transaction(function () use ($district, $isActive): Model {
            /** @var District */
            return $this->districts->update($district, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function activate(Model $district): Model
    {
        return $this->toggleStatus($district, true);
    }

    public function deactivate(Model $district): Model
    {
        return $this->toggleStatus($district, false);
    }

    public function delete(Model $district): bool
    {
        return $this->transaction(
            fn () => $this->districts->delete($district)
        );
    }
}
