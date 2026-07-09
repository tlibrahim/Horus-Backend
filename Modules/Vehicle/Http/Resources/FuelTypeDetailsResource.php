<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\FuelType;

/** @mixin FuelType */
final class FuelTypeDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return FuelTypeResource::make($this->resource)->toArray($request);
    }
}
