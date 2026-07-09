<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\DriveType;

interface DriveTypeServiceInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function options(): Collection;

    public function find(int|string $id): DriveType;
}
