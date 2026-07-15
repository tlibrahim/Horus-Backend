<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Vehicle;

use App\Support\Http\Resources\BaseResource;

class VehicleOptionResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'name' => trim(sprintf(
                '%s %s (%s)',
                $this->brand?->name,
                $this->model?->name,
                $this->plate_number ?? $this->vin
            )),
        ];
    }
}
