<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        Model $brand,
        array $attributes,
    ): Model {
        /** @var Brand */
        return $this->updateFromRepository($brand, $attributes);
    }

    public function toggleStatus(
        Model $brand,
        bool $isActive,
    ): Model {
        /** @var Brand */
        return $this->toggleStatusOnRepository($brand, $isActive);
    }

    public function activate(Model $brand): Model
    {
        /** @var Brand */
        return $this->activateOnRepository($brand);
    }

    public function deactivate(Model $brand): Model
    {
        /** @var Brand */
        return $this->deactivateOnRepository($brand);
    }

    public function delete(Model $brand): bool
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
