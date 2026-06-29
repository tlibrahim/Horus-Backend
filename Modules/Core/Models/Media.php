<?php

namespace Modules\Core\Models;

class Media extends BaseModel
{
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'is_public' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
