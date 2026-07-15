<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\FuelType;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\FuelType;

/** @mixin FuelType */
final class FuelTypeOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return ['label' => $this->name, 'value' => $this->id];
    }
}
