<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use App\Support\Filtering\FilterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CrudRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginate records.
     */
    public function paginate(
        int $perPage = 15,
        ?FilterInterface $filter = null,
        array $columns = ['*'],
    ): LengthAwarePaginator;

    /**
     * Retrieve options.
     */
    public function options(
        array $columns = ['id', 'name'],
        ?FilterInterface $filter = null,
    ): Collection;
}
