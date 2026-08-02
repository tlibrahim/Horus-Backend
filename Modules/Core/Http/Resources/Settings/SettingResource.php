<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources\Settings;

use App\Support\Http\Resources\BaseResource;

final class SettingResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'key' => $this->key,

            'group' => $this->group,

            'type' => $this->type,

            'value' => $this->value,

            'description' => $this->description,

            'is_public' => $this->is_public,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
