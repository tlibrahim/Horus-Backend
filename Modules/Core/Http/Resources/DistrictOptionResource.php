<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\District;

/**
 * @mixin District
 */
final class DistrictOptionResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
            'city_id' => $this->city_id,
            'postal_code' => $this->postal_code,
        ];
    }
}
