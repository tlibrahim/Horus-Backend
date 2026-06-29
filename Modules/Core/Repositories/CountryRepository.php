<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\CountryRepositoryInterface;
use Modules\Core\Models\Country;

final class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    protected function model(): string
    {
        return Country::class;
    }
}
