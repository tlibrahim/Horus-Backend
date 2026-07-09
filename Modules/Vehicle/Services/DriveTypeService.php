<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\DriveTypeRepositoryInterface;
use Modules\Vehicle\Contracts\DriveTypeServiceInterface;
use Modules\Vehicle\Filters\DriveTypeFilter;
use Modules\Vehicle\Models\DriveType;

final class DriveTypeService extends BaseService implements DriveTypeServiceInterface
{
    public function __construct(
        private readonly DriveTypeRepositoryInterface $driveTypes,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->driveTypes->paginate(
            perPage: $perPage,
            filter: new DriveTypeFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->driveTypes->options();
    }

    public function find(int|string $id): DriveType
    {
        /** @var DriveType */
        return $this->driveTypes->findOrFail($id);
    }
}
