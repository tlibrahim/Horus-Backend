<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\BodyType;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\BodyType;

/** @mixin BodyType */
final class BodyTypeDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return BodyTypeResource::make($this->resource)->toArray($request);
    }
}
