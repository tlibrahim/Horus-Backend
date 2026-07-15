<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Brand;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Brand;

/**
 * @mixin Brand
 */
final class BrandDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $this->logo,
            'country_id' => $this->country_id,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
