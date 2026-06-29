<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Core\Contracts\LanguageRepositoryInterface;
use Modules\Core\Models\Language;

final class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected function model(): string
    {
        return Language::class;
    }
}
