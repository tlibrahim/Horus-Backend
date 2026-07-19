<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleOwner;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;

interface VehicleOwnerRepositoryInterface extends CrudRepositoryInterface
{
    public function byVehicle(
        Vehicle $vehicle,
    ): Collection;

    public function primary(
        Vehicle $vehicle,
    ): ?VehicleOwner;

    public function active(
        Vehicle $vehicle,
    ): Collection;
}
