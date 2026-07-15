<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\VehicleType;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\VehicleType;

interface VehicleTypeServiceInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function options(): Collection;

    public function find(int|string $id): VehicleType;
}
