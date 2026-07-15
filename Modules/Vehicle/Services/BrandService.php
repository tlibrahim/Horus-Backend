<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\Brand\BrandRepositoryInterface;
use Modules\Vehicle\Contracts\Brand\BrandServiceInterface;
use Modules\Vehicle\Filters\BrandFilter;
use Modules\Vehicle\Models\Brand;

final class BrandService extends BaseCrudService implements BrandServiceInterface
{
    public function __construct(
        private readonly BrandRepositoryInterface $brands,
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

    public function find(int|string $id): Brand
    {
        /** @var Brand */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Brand
    {
        /** @var Brand */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Brand $brand,
        array $attributes,
    ): Brand {
        /** @var Brand */
        return $this->updateFromRepository($brand, $attributes);
    }

    public function toggleStatus(
        Brand $brand,
        bool $isActive,
    ): Brand {
        /** @var Brand */
        return $this->toggleStatusOnRepository($brand, $isActive);
    }

    public function delete(Brand $brand): bool
    {
        return $this->deleteFromRepository($brand);
    }

    protected function repository(): BrandRepositoryInterface
    {
        return $this->brands;
    }

    protected function filterClass(): ?string
    {
        return BrandFilter::class;
    }
}
