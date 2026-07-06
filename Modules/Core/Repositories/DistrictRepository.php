<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\DistrictRepositoryInterface;
use Modules\Core\Models\District;

final class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    protected function model(): string
    {
        return District::class;
    }
}
