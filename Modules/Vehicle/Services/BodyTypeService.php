<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\BodyTypeRepositoryInterface;
use Modules\Vehicle\Contracts\BodyTypeServiceInterface;
use Modules\Vehicle\Filters\BodyTypeFilter;
use Modules\Vehicle\Models\BodyType;

final class BodyTypeService extends BaseService implements BodyTypeServiceInterface
{
    public function __construct(
        private readonly BodyTypeRepositoryInterface $bodyTypes,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->bodyTypes->paginate(
            perPage: $perPage,
            filter: new BodyTypeFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->bodyTypes->options();
    }

    public function find(int|string $id): BodyType
    {
        /** @var BodyType */
        return $this->bodyTypes->findOrFail($id);
    }
}
