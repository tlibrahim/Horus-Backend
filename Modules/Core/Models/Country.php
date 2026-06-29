<?php

namespace Modules\Core\Models;

class Country extends BaseModel
{
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
