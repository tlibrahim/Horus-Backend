<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\Engine\EngineRepositoryInterface;
use Modules\Vehicle\Models\Engine;

final class EngineRepository extends BaseRepository implements EngineRepositoryInterface
{
    protected function model(): string
    {
        return Engine::class;
    }
}
