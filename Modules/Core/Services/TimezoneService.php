<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\TimezoneRepositoryInterface;
use Modules\Core\Contracts\TimezoneServiceInterface;
use Modules\Core\Filters\TimezoneFilter;
use Modules\Core\Models\Timezone;

final class TimezoneService extends BaseCrudService implements TimezoneServiceInterface
{
    public function __construct(
        private readonly TimezoneRepositoryInterface $timezones,
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

    public function find(int|string $id): Timezone
    {
        /** @var Timezone */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Timezone
    {
        /** @var Timezone */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Timezone $timezone,
        array $attributes,
    ): Timezone {
        /** @var Timezone */
        return $this->updateFromRepository($timezone, $attributes);
    }

    public function toggleStatus(
        Timezone $timezone,
        bool $isActive,
    ): Timezone {
        /** @var Timezone */
        return $this->toggleStatusOnRepository($timezone, $isActive);
    }

    public function delete(Timezone $timezone): bool
    {
        return $this->deleteFromRepository($timezone);
    }

    protected function repository(): TimezoneRepositoryInterface
    {
        return $this->timezones;
    }

    protected function filterClass(): ?string
    {
        return TimezoneFilter::class;
    }
}
