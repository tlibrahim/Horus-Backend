<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\LanguageRepositoryInterface;
use Modules\Core\Contracts\LanguageServiceInterface;
use Modules\Core\Filters\LanguageFilter;
use Modules\Core\Models\Language;

final class LanguageService extends BaseService implements LanguageServiceInterface
{
    public function __construct(
        private readonly LanguageRepositoryInterface $languages,
    ) {}

    public function all(): Collection
    {
        return $this->languages->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->languages->paginate(
            perPage: $perPage,
            filter: new LanguageFilter(request()),
        );
    }

    public function options(): Collection
    {
        return $this->languages->options();
    }

    public function find(int|string $id): Language
    {
        /** @var Language */
        return $this->languages->findOrFail($id);
    }

    public function create(array $attributes): Language
    {
        /** @var Language */
        return $this->transaction(
            fn () => $this->languages->create($attributes)
        );
    }

    public function update(
        Language $language,
        array $attributes,
    ): Language {
        /** @var Language */
        return $this->transaction(
            fn () => $this->languages->update($language, $attributes)
        );
    }

    public function toggleStatus(
        Language $language,
        bool $isActive,
    ): Language {
        return $this->transaction(function () use ($language, $isActive) {
            /** @var Language */
            return $this->languages->update($language, [
                'is_active' => $isActive,
            ]);
        });
    }

    public function delete(Language $language): bool
    {
        return $this->transaction(
            fn () => $this->languages->delete($language)
        );
    }
}
