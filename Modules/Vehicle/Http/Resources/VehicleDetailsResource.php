<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vehicle\Models\Vehicle;

/**
 * @mixin Vehicle
 */
final class VehicleDetailsResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'user_id' => $this->user_id,

            'brand' => BrandResource::make(
                $this->whenLoaded('brand')
            ),

            'model' => VehicleModelResource::make(
                $this->whenLoaded('model')
            ),

            'generation' => GenerationResource::make(
                $this->whenLoaded('generation')
            ),

            'engine' => EngineResource::make(
                $this->whenLoaded('engine')
            ),

            'body_type' => BodyTypeResource::make(
                $this->whenLoaded('bodyType')
            ),

            'drive_type' => DriveTypeResource::make(
                $this->whenLoaded('driveType')
            ),

            'vehicle_type' => VehicleTypeResource::make(
                $this->whenLoaded('vehicleType')
            ),

            'vin' => $this->vin,

            'plate_number' => $this->plate_number,

            'manufacture_year' => $this->manufacture_year,

            'current_mileage' => $this->current_mileage,

            'color' => $this->color,

            'is_primary' => $this->is_primary,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

            'deleted_at' => $this->deleted_at,
        ];
    }
}
