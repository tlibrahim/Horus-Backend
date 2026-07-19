<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleDocument;

use App\Support\Http\Resources\BaseResource;

final class VehicleDocumentTypeResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'requires_number' => $this->requires_number,
            'requires_expiry' => $this->requires_expiry,
            'is_active' => $this->is_active,
        ];
    }
}
