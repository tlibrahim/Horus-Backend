<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\TimezoneRepositoryInterface;
use Modules\Core\Contracts\TimezoneServiceInterface;
use Modules\Core\Filters\TimezoneFilter;
use Modules\Core\Models\Timezone;

final class TimezoneService extends BaseService implements TimezoneServiceInterface
{
    public function __construct(
        private readonly TimezoneRepositoryInterface $timezones,
    ) {}

    public function all(): Collection
    {
        return $this->timezones->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->timezones->paginate(
            perPage: $perPage,
            filter: new TimezoneFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->timezones->options();
    }

    public function find(int|string $id): Timezone
    {
        /** @var Timezone */
        return $this->timezones->findOrFail($id);
    }

    public function create(array $attributes): Timezone
    {
        /** @var Timezone */
        return $this->transaction(
            fn () => $this->timezones->create($attributes)
        );
    }

    public function update(
        Timezone $timezone,
        array $attributes,
    ): Timezone {
        /** @var Timezone */
        return $this->transaction(
            fn () => $this->timezones->update($timezone, $attributes)
        );
    }

    public function toggleStatus(
        Timezone $timezone,
        bool $isActive,
    ): Timezone {
        return $this->transaction(function () use ($timezone, $isActive) {
            /** @var Timezone */
            return $this->timezones->update($timezone, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(Timezone $timezone): bool
    {
        return $this->transaction(
            fn () => $this->timezones->delete($timezone)
        );
    }
}
