<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\TimezoneFactory;

class Timezone extends BaseModel
{
    use HasFactory;

    protected static function newFactory()
    {
        return TimezoneFactory::new();
    }
}
