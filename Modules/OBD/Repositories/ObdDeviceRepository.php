<?php

declare(strict_types=1);

namespace Modules\OBD\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\OBD\Contracts\Repositories\ObdDeviceRepositoryInterface;
use Modules\OBD\Models\ObdDevice;

class ObdDeviceRepository extends BaseRepository implements ObdDeviceRepositoryInterface
{
    protected function model(): string
    {
        return ObdDevice::class;
    }
}
