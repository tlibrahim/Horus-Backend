<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Modules\Vehicle\Http\Resources\Common\LookupResource;

class VehicleResource extends BaseResource
{
    public function toArray($request): array
    {
        return [

            'id' => $this->id,

            'user_id' => $this->user_id,

            'vin' => $this->vin,

            'plate_number' => $this->plate_number,

            'manufacture_year' => $this->manufacture_year,

            'current_mileage' => $this->current_mileage,

            'color' => $this->color,

            'is_primary' => $this->is_primary,

            'brand' => LookupResource::make($this->whenLoaded('brand')),

            'model' => LookupResource::make($this->whenLoaded('model')),

            'generation' => LookupResource::make($this->whenLoaded('generation')),

            'engine' => $this->engine
                ? [
                    'id' => $this->engine->id,
                    'name' => $this->engine->name,
                    'code' => $this->engine->code,
                    'horse_power' => $this->engine->horse_power,
                ]
                : null,

            'body_type' => LookupResource::make($this->whenLoaded('bodyType')),

            'drive_type' => LookupResource::make($this->whenLoaded('driveType')),

            'vehicle_type' => LookupResource::make($this->whenLoaded('vehicleType')),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
