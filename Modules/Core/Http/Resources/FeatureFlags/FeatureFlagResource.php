<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources\FeatureFlags;

use App\Support\Http\Resources\BaseResource;

final class FeatureFlagResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'key' => $this->key,

            'enabled' => $this->enabled,

            'description' => $this->description,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
