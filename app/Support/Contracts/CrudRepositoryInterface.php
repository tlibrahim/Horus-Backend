<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use App\Support\Filtering\FilterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    /**
     * Paginate records.
     */
    public function paginate(
        int $perPage = 15,
        array $columns = ['*'],
        ?FilterInterface $filter = null,
    ): LengthAwarePaginator;

    /**
     * Retrieve options.
     */
    public function options(
        array $columns = ['id', 'name'],
        ?FilterInterface $filter = null,
    ): Collection;

    /**
     * Find a model.
     */
    public function find(
        int|string $id,
        array $relations = [],
    ): Model;

    /**
     * Create a model.
     */
    public function create(array $attributes): Model;

    /**
     * Update a model.
     */
    public function update(
        Model $model,
        array $attributes,
    ): Model;

    /**
     * Delete a model.
     */
    public function delete(Model $model): bool;
}
