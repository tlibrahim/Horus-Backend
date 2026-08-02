<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\FeatureFlags\Repositories\FeatureFlagRepositoryInterface;
use Modules\Core\Contracts\FeatureFlags\Services\FeatureFlagServiceInterface;
use Modules\Core\Filters\FeatureFlagFilter;
use Modules\Core\Models\FeatureFlag;

final class FeatureFlagService extends BaseCrudService implements FeatureFlagServiceInterface
{
    public function __construct(
        private readonly FeatureFlagRepositoryInterface $features,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    */

    public function all(): iterable
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

    public function find(int|string $id): FeatureFlag
    {
        /** @var FeatureFlag */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): FeatureFlag
    {
        /** @var FeatureFlag */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Model $featureFlag,
        array $attributes,
    ): Model {
        /** @var FeatureFlag */
        return $this->updateFromRepository(
            $featureFlag,
            $attributes,
        );
    }

    public function delete(
        Model $featureFlag,
    ): bool {
        return $this->deleteFromRepository($featureFlag);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Methods
    |--------------------------------------------------------------------------
    */

    public function findByKey(string $key): ?FeatureFlag
    {
        return $this->features->findByKey($key);
    }

    public function isEnabled(string $key): bool
    {
        return $this->features->isEnabled($key);
    }

    public function enable(string $key): FeatureFlag
    {
        return $this->features->enable($key);
    }

    public function disable(string $key): FeatureFlag
    {
        return $this->features->disable($key);
    }

    public function enabled(): Collection
    {
        return $this->features->enabled();
    }

    public function disabled(): Collection
    {
        return $this->features->disabled();
    }

    /*
    |--------------------------------------------------------------------------
    | BaseCrudService
    |--------------------------------------------------------------------------
    */

    protected function repository(): FeatureFlagRepositoryInterface
    {
        return $this->features;
    }

    protected function filterClass(): ?string
    {
        return FeatureFlagFilter::class;
    }
}
