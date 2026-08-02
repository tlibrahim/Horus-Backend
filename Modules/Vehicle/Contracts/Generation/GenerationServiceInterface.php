<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\Generation;

use App\Support\Contracts\ActivatableServiceInterface;
use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Generation;

interface GenerationServiceInterface extends ActivatableServiceInterface, CrudServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Generation;

    public function create(array $attributes): Generation;

    public function options(): Collection;
}
