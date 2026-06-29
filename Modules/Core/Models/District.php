<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Database\Factories\DistrictFactory;

class District extends BaseModel
{
    use HasFactory;

    protected static function newFactory()
    {
        return DistrictFactory::new();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
