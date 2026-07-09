<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\FuelTypeRepositoryInterface;
use Modules\Vehicle\Models\FuelType;

final class FuelTypeRepository extends BaseRepository implements FuelTypeRepositoryInterface
{
    protected function model(): string
    {
        return FuelType::class;
    }
}
