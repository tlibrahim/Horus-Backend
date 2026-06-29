<?php

namespace Modules\Core\Models;

class ActivityLog extends BaseModel
{
    protected function casts(): array
    {
        return [
            'properties' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
