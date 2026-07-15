<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\Generation\GenerationRepositoryInterface;
use Modules\Vehicle\Contracts\Generation\GenerationServiceInterface;
use Modules\Vehicle\Filters\GenerationFilter;
use Modules\Vehicle\Models\Generation;

final class GenerationService extends BaseCrudService implements GenerationServiceInterface
{
    public function __construct(
        private readonly GenerationRepositoryInterface $generations,
    ) {}

    public function all(): Collection
    {
        return $this->allFromRepository();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(int|string $id): Generation
    {
        /** @var Generation */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Generation
    {
        /** @var Generation */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Generation $generation,
        array $attributes,
    ): Generation {
        /** @var Generation */
        return $this->updateFromRepository($generation, $attributes);
    }

    public function toggleStatus(
        Generation $generation,
        bool $isActive,
    ): Generation {
        /** @var Generation */
        return $this->toggleStatusOnRepository($generation, $isActive);
    }

    public function delete(Generation $generation): bool
    {
        return $this->deleteFromRepository($generation);
    }

    protected function repository(): GenerationRepositoryInterface
    {
        return $this->generations;
    }

    protected function filterClass(): ?string
    {
        return GenerationFilter::class;
    }
}
