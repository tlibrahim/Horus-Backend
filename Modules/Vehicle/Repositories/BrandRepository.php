<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\BrandRepositoryInterface;
use Modules\Vehicle\Models\Brand;

final class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    protected function model(): string
    {
        return Brand::class;
    }
}
