<?php

namespace Modules\Core\Models;

class Address extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
