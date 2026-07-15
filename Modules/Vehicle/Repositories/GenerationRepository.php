<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\Generation\GenerationRepositoryInterface;
use Modules\Vehicle\Models\Generation;

final class GenerationRepository extends BaseRepository implements GenerationRepositoryInterface
{
    protected function model(): string
    {
        return Generation::class;
    }
}
