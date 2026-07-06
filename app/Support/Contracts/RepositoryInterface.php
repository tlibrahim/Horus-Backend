<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use App\Support\Filtering\FilterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Retrieve all records.
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Retrieve paginated records.
     */
    public function paginate(
        int $perPage = 15,
        array $columns = ['*'],
    ): LengthAwarePaginator;

    /**
     * Find a record by its primary key.
     */
    public function find(int|string $id): ?Model;

    /**
     * Find a record by its primary key or fail.
     */
    public function findOrFail(int|string $id): Model;

    /**
     * Create a new record.
     */
    public function create(array $attributes): Model;

    /**
     * Update an existing model.
     */
    public function update(
        Model $model,
        array $attributes,
    ): Model;

    /**
     * Retrieve lightweight options for select inputs.
     */
    public function options(
        array $columns = ['id', 'name'],
        ?FilterInterface $filter = null,
    ): Collection;

    /**
     * Delete a model.
     */
    public function delete(Model $model): bool;
}
