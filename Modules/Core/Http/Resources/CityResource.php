<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\City;

/**
 * @mixin City
 */
final class CityResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'country_id' => $this->country_id,
            'name' => $this->name,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'is_active' => $this->is_active,

            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
