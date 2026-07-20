<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\OBD\Repositories\ObdDeviceRepositoryInterface;
use Modules\Vehicle\Models\ObdDevice;

class ObdDeviceRepository extends BaseRepository implements ObdDeviceRepositoryInterface
{
    protected function model(): string
    {
        return ObdDevice::class;
    }
}
