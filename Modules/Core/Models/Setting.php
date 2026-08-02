<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\SettingFactory;

class Setting extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): SettingFactory
    {
        return new SettingFactory;
    }

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_editable' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
