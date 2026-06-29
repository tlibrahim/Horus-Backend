<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\TimezoneRepositoryInterface;
use Modules\Core\Models\Timezone;

final class TimezoneRepository extends BaseRepository implements TimezoneRepositoryInterface
{
    protected function model(): string
    {
        return Timezone::class;
    }
}
