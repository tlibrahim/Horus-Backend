<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\CountryRepositoryInterface;
use Modules\Core\Contracts\CountryServiceInterface;
use Modules\Core\Filters\CountryFilter;
use Modules\Core\Models\Country;

final class CountryService extends BaseCrudService implements CountryServiceInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $countries,
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

    public function find(int|string $id): Country
    {
        /** @var Country */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Country
    {
        /** @var Country */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Model $country,
        array $attributes,
    ): Model {
        /** @var Country */
        return $this->updateFromRepository($country, $attributes);
    }

    public function toggleStatus(Model $country, bool $isActive): Model
    {
        /** @var Country */
        return $this->toggleStatusOnRepository($country, $isActive);
    }

    public function activate(Model $country): Model
    {
        /** @var Country */
        return $this->activateOnRepository($country);
    }

    public function deactivate(Model $country): Model
    {
        /** @var Country */
        return $this->deactivateOnRepository($country);
    }

    public function delete(Model $country): bool
    {
        return $this->deleteFromRepository($country);
    }

    protected function repository(): CountryRepositoryInterface
    {
        return $this->countries;
    }

    protected function filterClass(): ?string
    {
        return CountryFilter::class;
    }
}
