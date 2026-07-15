<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class VehicleImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'url' => $this->url,

            'is_primary' => $this->is_primary,

            'sort_order' => $this->sort_order,
        ];
    }
}
