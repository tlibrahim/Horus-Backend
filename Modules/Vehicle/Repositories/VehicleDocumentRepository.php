<?php

declare(strict_types=1);

namespace Modules\Vehicle\Repositories;

use App\Support\Repositories\BaseRepository;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentRepositoryInterface;
use Modules\Vehicle\Models\VehicleDocument;

final class VehicleDocumentRepository extends BaseRepository implements VehicleDocumentRepositoryInterface
{
    protected function model(): string
    {
        return VehicleDocument::class;
    }
}
