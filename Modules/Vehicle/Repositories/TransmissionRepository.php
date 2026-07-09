<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\TransmissionRepositoryInterface;
use Modules\Vehicle\Models\Transmission;

final class TransmissionRepository extends BaseRepository implements TransmissionRepositoryInterface
{
    protected function model(): string
    {
        return Transmission::class;
    }
}
