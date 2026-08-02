<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\CurrencyRepositoryInterface;
use Modules\Core\Contracts\CurrencyServiceInterface;
use Modules\Core\Filters\CurrencyFilter;
use Modules\Core\Models\Currency;

final class CurrencyService extends BaseCrudService implements CurrencyServiceInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencies,
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

    public function find(int|string $id): Currency
    {
        /** @var Currency */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Currency
    {
        /** @var Currency */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Model $currency,
        array $attributes,
    ): Model {
        /** @var Currency */
        return $this->updateFromRepository($currency, $attributes);
    }

    public function toggleStatus(Model $currency, bool $isActive): Model
    {
        /** @var Currency */
        return $this->toggleStatusOnRepository($currency, $isActive);
    }

    public function activate(Model $currency): Model
    {
        /** @var Currency */
        return $this->activateOnRepository($currency);
    }

    public function deactivate(Model $currency): Model
    {
        /** @var Currency */
        return $this->deactivateOnRepository($currency);
    }

    public function delete(Model $currency): bool
    {
        return $this->deleteFromRepository($currency);
    }

    protected function repository(): CurrencyRepositoryInterface
    {
        return $this->currencies;
    }

    protected function filterClass(): ?string
    {
        return CurrencyFilter::class;
    }
}
