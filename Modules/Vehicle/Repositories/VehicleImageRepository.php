<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageRepositoryInterface;
use Modules\Vehicle\Models\VehicleImage;

final class VehicleImageRepository extends BaseRepository implements VehicleImageRepositoryInterface
{
    protected function model(): string
    {
        return VehicleImage::class;
    }
}
