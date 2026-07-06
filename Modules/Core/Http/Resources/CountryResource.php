<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\Country;

/**
 * @mixin Country
 */
final class CountryResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'iso2' => $this->iso2,

            'iso3' => $this->iso3,

            'flag' => $this->flag,

            'phone_code' => $this->phone_code,

            'is_active' => (bool) $this->is_active,
        ];
    }
}
