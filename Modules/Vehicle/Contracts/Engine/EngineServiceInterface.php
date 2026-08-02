<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\Engine;

use App\Support\Contracts\ActivatableServiceInterface;
use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\Engine;

interface EngineServiceInterface extends ActivatableServiceInterface, CrudServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Engine;

    public function create(array $attributes): Engine;

    public function options(): Collection;
}
