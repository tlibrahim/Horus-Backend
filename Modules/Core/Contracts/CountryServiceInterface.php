<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Country;

interface CountryServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Country;

    public function create(array $attributes): Country;

    public function update(Country $country, array $attributes): Country;

    public function options(): Collection;

    public function toggleStatus(Country $country, bool $isActive): Country;

    public function delete(Country $country): bool;
}
