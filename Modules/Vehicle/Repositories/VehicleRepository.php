<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\VehicleRepositoryInterface;
use Modules\Vehicle\Models\Vehicle;

final class VehicleRepository extends BaseRepository implements VehicleRepositoryInterface
{
    protected function model(): string
    {
        return Vehicle::class;
    }
}
