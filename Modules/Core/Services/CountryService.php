<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\CountryRepositoryInterface;
use Modules\Core\Contracts\CountryServiceInterface;
use Modules\Core\Filters\CountryFilter;
use Modules\Core\Models\Country;

final class CountryService extends BaseService implements CountryServiceInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $countries,
    ) {}

    public function all(): Collection
    {
        return $this->countries->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->countries->paginate(
            perPage: $perPage,
            filter: new CountryFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->countries->options();
    }

    public function find(int|string $id): Country
    {
        /** @var Country */
        return $this->countries->findOrFail($id);
    }

    public function create(array $attributes): Country
    {
        /** @var Country */
        return $this->transaction(
            fn () => $this->countries->create($attributes)
        );
    }

    public function update(
        Country $country,
        array $attributes,
    ): Country {
        /** @var Country */
        return $this->transaction(
            fn () => $this->countries->update($country, $attributes)
        );
    }

    public function toggleStatus(
        Country $country,
        bool $isActive,
    ): Country {
        return $this->transaction(function () use ($country, $isActive) {
            /** @var Country */
            return $this->countries->update($country, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(Country $country): bool
    {
        return $this->transaction(
            fn () => $this->countries->delete($country)
        );
    }
}
