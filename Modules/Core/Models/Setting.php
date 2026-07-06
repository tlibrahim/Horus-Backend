<?php

namespace Modules\Core\Models;

class Setting extends BaseModel
{
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
