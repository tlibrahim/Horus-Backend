<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\DriveType;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\DriveType;

/** @mixin DriveType */
final class DriveTypeDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return DriveTypeResource::make($this->resource)->toArray($request);
    }
}
