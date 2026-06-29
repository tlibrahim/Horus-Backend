<?php

namespace Modules\Core\Models;

class City extends BaseModel
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
