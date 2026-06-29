<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Currency;

interface CurrencyServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Currency;

    public function create(array $attributes): Currency;

    public function update(Currency $currency, array $attributes): Currency;

    public function options(): Collection;

    public function toggleStatus(Currency $currency, bool $isActive): Currency;

    public function delete(Currency $currency): bool;
}
