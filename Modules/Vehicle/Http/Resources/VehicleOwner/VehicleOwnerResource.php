<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleOwner;

use App\Support\Http\Resources\BaseResource;

final class VehicleOwnerResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'user_id' => $this->user_id,

            'ownership_type' => $this->ownership_type,

            'is_primary' => $this->is_primary,

            'ownership_percentage' => $this->ownership_percentage,

            'started_at' => $this->started_at,

            'ended_at' => $this->ended_at,

            'created_at' => $this->created_at,
        ];
    }
}
