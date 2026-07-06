<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\City;

/**
 * @mixin City
 */
final class CityOptionResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
            'country_id' => $this->country_id,
        ];
    }
}
