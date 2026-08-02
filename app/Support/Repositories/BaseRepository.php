<?php

declare(strict_types=1);

namespace App\Support\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use App\Support\Filtering\FilterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements CrudRepositoryInterface
{
    /**
     * Get the model class handled by the repository.
     *
     * @return class-string<Model>
     */
    abstract protected function model(): string;

    /**
     * Create a new query builder.
     */
    protected function query(): Builder
    {
        return $this->model()::query();
    }

    /**
     * Retrieve all records.
     */
    public function all(
        array $columns = ['*'],
        ?FilterInterface $filter = null,
    ): Collection {

        $query = $this->query();

        if ($filter !== null) {
            $query = $filter->apply($query);
        }

        return $query->get($columns);
    }

    /**
     * Retrieve paginated records.
     */
    public function paginate(int $perPage = 15, ?FilterInterface $filter = null, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->query();

        if ($filter !== null) {
            $query = $filter->apply($query);
        }

        return $query->paginate(
            perPage: $perPage,
            columns: $columns,
        );
    }

    /**
     * Find a record by its primary key.
     */
    public function find(int|string $id): ?Model
    {
        return $this->query()->find($id);
    }

    /**
     * Find a record by its primary key or fail.
     */
    public function findOrFail(int|string $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $attributes): Model
    {
        return $this->query()->create($attributes);
    }

    /**
     * Update an existing record.
     */
    public function update(
        Model $model,
        array $attributes,
    ): Model {
        $model->fill($attributes);

        $model->save();

        return $model->refresh();
    }

    /**
     * Retrieve lightweight options for select inputs.
     */
    public function options(
        array $columns = ['id', 'name'],
        ?FilterInterface $filter = null,
    ): Collection {

        $query = $this->query();

        if ($filter !== null) {
            $query = $filter->apply($query);
        }

        return $query->get($columns);
    }

    public function toggleStatus(Model $model, bool $isActive): Model
    {
        return $this->update($model, [
            'is_active' => $isActive,
        ]);
    }

    public function activate(Model $model): Model
    {
        return $this->toggleStatus($model, true);
    }

    public function deactivate(Model $model): Model
    {
        return $this->toggleStatus($model, false);
    }

    /**
     * Delete a model.
     */
    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }
}
