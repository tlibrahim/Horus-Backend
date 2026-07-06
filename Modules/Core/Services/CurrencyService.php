<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\CurrencyRepositoryInterface;
use Modules\Core\Contracts\CurrencyServiceInterface;
use Modules\Core\Filters\CurrencyFilter;
use Modules\Core\Models\Currency;

final class CurrencyService extends BaseService implements CurrencyServiceInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencies,
    ) {}

    public function all(): Collection
    {
        return $this->currencies->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->currencies->paginate(
            perPage: $perPage,
            filter: new CurrencyFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->currencies->options();
    }

    public function find(int|string $id): Currency
    {
        /** @var Currency */
        return $this->currencies->findOrFail($id);
    }

    public function create(array $attributes): Currency
    {
        /** @var Currency */
        return $this->transaction(
            fn () => $this->currencies->create($attributes)
        );
    }

    public function update(
        Currency $currency,
        array $attributes,
    ): Currency {
        /** @var Currency */
        return $this->transaction(
            fn () => $this->currencies->update($currency, $attributes)
        );
    }

    public function toggleStatus(
        Currency $currency,
        bool $isActive,
    ): Currency {
        return $this->transaction(function () use ($currency, $isActive) {
            /** @var Currency */
            return $this->currencies->update($currency, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(Currency $currency): bool
    {
        return $this->transaction(
            fn () => $this->currencies->delete($currency)
        );
    }
}
