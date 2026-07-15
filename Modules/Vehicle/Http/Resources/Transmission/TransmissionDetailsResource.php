<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Transmission;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Transmission;

/** @mixin Transmission */
final class TransmissionDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return TransmissionResource::make($this->resource)->toArray($request);
    }
}
