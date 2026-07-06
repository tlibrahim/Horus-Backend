<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\District;

/**
 * @mixin District
 */
final class DistrictResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'city_id' => $this->city_id,
            'name' => $this->name,
            'postal_code' => $this->postal_code,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'is_active' => $this->is_active,

            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
