<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\Engine\EngineRepositoryInterface;
use Modules\Vehicle\Contracts\Engine\EngineServiceInterface;
use Modules\Vehicle\Filters\EngineFilter;
use Modules\Vehicle\Models\Engine;

final class EngineService extends BaseCrudService implements EngineServiceInterface
{
    public function __construct(
        private readonly EngineRepositoryInterface $engines,
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
        return $this->optionsFromRepository(['id', 'code as name']);
    }

    public function find(int|string $id): Engine
    {
        /** @var Engine */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Engine
    {
        /** @var Engine */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Engine $engine,
        array $attributes,
    ): Engine {
        /** @var Engine */
        return $this->updateFromRepository($engine, $attributes);
    }

    public function toggleStatus(
        Engine $engine,
        bool $isActive,
    ): Engine {
        /** @var Engine */
        return $this->toggleStatusOnRepository($engine, $isActive);
    }

    public function delete(Engine $engine): bool
    {
        return $this->deleteFromRepository($engine);
    }

    protected function repository(): EngineRepositoryInterface
    {
        return $this->engines;
    }

    protected function filterClass(): ?string
    {
        return EngineFilter::class;
    }
}
