<?php

namespace Modules\Core\Models;

class Setting extends BaseModel
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
