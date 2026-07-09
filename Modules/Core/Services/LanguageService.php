<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\LanguageRepositoryInterface;
use Modules\Core\Contracts\LanguageServiceInterface;
use Modules\Core\Filters\LanguageFilter;
use Modules\Core\Models\Language;

final class LanguageService extends BaseCrudService implements LanguageServiceInterface
{
    public function __construct(
        private readonly LanguageRepositoryInterface $languages,
    ) {}

    public function all(): Collection
    {
        return $this->allFromRepository();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(int|string $id): Language
    {
        /** @var Language */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Language
    {
        /** @var Language */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Language $language,
        array $attributes,
    ): Language {
        /** @var Language */
        return $this->updateFromRepository($language, $attributes);
    }

    public function toggleStatus(
        Language $language,
        bool $isActive,
    ): Language {
        /** @var Language */
        return $this->toggleStatusOnRepository($language, $isActive);
    }

    public function delete(Language $language): bool
    {
        return $this->deleteFromRepository($language);
    }

    protected function repository(): LanguageRepositoryInterface
    {
        return $this->languages;
    }

    protected function filterClass(): ?string
    {
        return LanguageFilter::class;
    }
}
