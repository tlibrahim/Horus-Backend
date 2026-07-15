<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\BodyType\BodyTypeRepositoryInterface;
use Modules\Vehicle\Models\BodyType;

final class BodyTypeRepository extends BaseRepository implements BodyTypeRepositoryInterface
{
    protected function model(): string
    {
        return BodyType::class;
    }
}
