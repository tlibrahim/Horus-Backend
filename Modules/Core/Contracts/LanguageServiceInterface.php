<?php

declare(strict_types=1);

namespace Modules\Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Language;

interface LanguageServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): Language;

    public function create(array $attributes): Language;

    public function update(Language $language, array $attributes): Language;

    public function options(): Collection;

    public function toggleStatus(Language $language, bool $isActive): Language;

    public function delete(Language $language): bool;
}
