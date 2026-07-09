<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\DriveTypeRepositoryInterface;
use Modules\Vehicle\Models\DriveType;

final class DriveTypeRepository extends BaseRepository implements DriveTypeRepositoryInterface
{
    protected function model(): string
    {
        return DriveType::class;
    }
}
