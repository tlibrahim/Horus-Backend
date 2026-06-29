<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\CurrencyFactory;

class Currency extends BaseModel
{
    use HasFactory;

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
