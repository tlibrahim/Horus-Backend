<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\VehicleModelRepositoryInterface;
use Modules\Vehicle\Models\VehicleModel;

final class VehicleModelRepository extends BaseRepository implements VehicleModelRepositoryInterface
{
    protected function model(): string
    {
        return VehicleModel::class;
    }
}
