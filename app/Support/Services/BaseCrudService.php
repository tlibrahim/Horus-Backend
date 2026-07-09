<?php

declare(strict_types=1);

namespace App\Support\Services;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Filtering\FilterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService extends BaseService
{
    abstract protected function repository(): CrudRepositoryInterface;

    /**
     * @return class-string<FilterInterface>|null
     */
    protected function filterClass(): ?string
    {
        return null;
    }

    protected function allFromRepository(): Collection
    {
        return $this->repository()->all();
    }

    protected function paginateFromRepository(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository()->paginate(
            perPage: $perPage,
            filter: $this->makeFilter(),
        );
    }

    protected function optionsFromRepository(array $columns = ['id', 'name']): Collection
    {
        return $this->repository()->options(
            columns: $columns,
        );
    }

    protected function findFromRepository(int|string $id): Model
    {
        return $this->repository()->findOrFail($id);
    }

    protected function createFromRepository(array $attributes): Model
    {
        return $this->transaction(
            fn () => $this->repository()->create($attributes)
        );
    }

    protected function updateFromRepository(Model $model, array $attributes): Model
    {
        return $this->transaction(
            fn () => $this->repository()->update($model, $attributes)
        );
    }

    protected function deleteFromRepository(Model $model): bool
    {
        return $this->transaction(
            fn () => $this->repository()->delete($model)
        );
    }

    protected function toggleStatusOnRepository(Model $model, bool $isActive): Model
    {
        return $this->updateFromRepository($model, [
            'is_active' => $isActive,
        ]);
    }

    protected function activateOnRepository(Model $model): Model
    {
        return $this->toggleStatusOnRepository($model, true);
    }

    protected function deactivateOnRepository(Model $model): Model
    {
        return $this->toggleStatusOnRepository($model, false);
    }

    private function makeFilter(): ?FilterInterface
    {
        $filterClass = $this->filterClass();

        if ($filterClass === null) {
            return null;
        }

        return new $filterClass(request());
    }
}
