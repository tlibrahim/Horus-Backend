<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleType;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\VehicleType;

/** @mixin VehicleType */
final class VehicleTypeDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return VehicleTypeResource::make($this->resource)->toArray($request);
    }
}
