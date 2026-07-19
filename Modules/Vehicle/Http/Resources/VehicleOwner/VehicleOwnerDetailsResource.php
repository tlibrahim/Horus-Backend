<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleOwner;

use App\Support\Http\Resources\BaseResource;

final class VehicleOwnerDetailsResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'vehicle_id' => $this->vehicle_id,

            'user_id' => $this->user_id,

            'ownership_type' => $this->ownership_type,

            'is_primary' => $this->is_primary,

            'ownership_percentage' => $this->ownership_percentage,

            'started_at' => $this->started_at,

            'ended_at' => $this->ended_at,

            'notes' => $this->notes,

            'vehicle' => [
                'id' => $this->vehicle?->id,
                'plate_number' => $this->vehicle?->plate_number,
            ],

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
