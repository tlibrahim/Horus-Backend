<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\Timezone;

/**
 * @mixin Timezone
 */
final class TimezoneResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'utc_offset' => $this->utc_offset,

            'is_active' => $this->is_active,

            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
