<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\Country;

/**
 * @mixin Country
 */
final class CountryDetailsResource extends BaseResource
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

            'phone_code' => $this->phone_code,

            'currency_id' => $this->currency_id,

            'language_id' => $this->language_id,

            'timezone_id' => $this->timezone_id,

            'nationality' => $this->nationality,

            'flag' => $this->flag,

            'latitude' => $this->latitude,

            'longitude' => $this->longitude,

            'is_active' => (bool) $this->is_active,

            /*
             |--------------------------------------------------------------
             | Relationships
             |--------------------------------------------------------------
             |
             | Enable these once the related resources are implemented.
             |
             */

            // 'currency' => CurrencyResource::make(
            //     $this->whenLoaded('currency')
            // ),

            // 'language' => LanguageResource::make(
            //     $this->whenLoaded('language')
            // ),

            // 'timezone' => TimezoneResource::make(
            //     $this->whenLoaded('timezone')
            // ),

            'created_at' => $this->formatDate($this->created_at),

            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
