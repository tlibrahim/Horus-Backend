<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use App\Support\Contracts\ActivatableServiceInterface;
use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Language;

interface LanguageServiceInterface extends ActivatableServiceInterface, CrudServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Language;

    public function create(array $attributes): Language;

    public function options(): Collection;
}
