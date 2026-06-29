<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\CurrencyRepositoryInterface;
use Modules\Core\Models\Currency;

final class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    protected function model(): string
    {
        return Currency::class;
    }
}
