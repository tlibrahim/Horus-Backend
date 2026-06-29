<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Timezone;

interface TimezoneServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Timezone;

    public function create(array $attributes): Timezone;

    public function update(Timezone $timezone, array $attributes): Timezone;

    public function options(): Collection;

    public function toggleStatus(Timezone $timezone, bool $isActive): Timezone;

    public function delete(Timezone $timezone): bool;
}
