<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\CityRepositoryInterface;
use Modules\Core\Models\City;

final class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    protected function model(): string
    {
        return City::class;
    }
}
