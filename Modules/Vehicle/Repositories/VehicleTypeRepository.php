<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\VehicleTypeRepositoryInterface;
use Modules\Vehicle\Models\VehicleType;

final class VehicleTypeRepository extends BaseRepository implements VehicleTypeRepositoryInterface
{
    protected function model(): string
    {
        return VehicleType::class;
    }
}
