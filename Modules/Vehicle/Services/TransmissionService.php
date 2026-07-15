<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\Transmission\TransmissionRepositoryInterface;
use Modules\Vehicle\Contracts\Transmission\TransmissionServiceInterface;
use Modules\Vehicle\Filters\TransmissionFilter;
use Modules\Vehicle\Models\Transmission;

final class TransmissionService extends BaseService implements TransmissionServiceInterface
{
    public function __construct(
        private readonly TransmissionRepositoryInterface $transmissions,
    ) {}

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->transmissions->paginate(
            perPage: $perPage,
            filter: new TransmissionFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->transmissions->options();
    }

    public function find(int|string $id): Transmission
    {
        /** @var Transmission */
        return $this->transmissions->findOrFail($id);
    }
}
