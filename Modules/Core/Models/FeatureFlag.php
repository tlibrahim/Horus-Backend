<?php

namespace Modules\Core\Models;

class FeatureFlag extends BaseModel
{
    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
