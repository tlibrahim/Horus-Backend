<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudServiceInterface extends ServiceInterface
{
    /**
     * Retrieve all records.
     */
    public function all(): iterable;

    /**
     * Paginate records.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Retrieve options.
     */
    public function options(): Collection;

    /**
     * Find a record by its primary key.
     */
    public function find(int|string $id): Model;

    /**
     * Create a new record.
     */
    public function create(array $attributes): Model;

    /**
     * Update an existing model.
     */
    public function update(Model $model, array $attributes): Model;

    /**
     * Delete a model.
     */
    public function delete(Model $model): bool;
}
