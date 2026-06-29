<?php

namespace Modules\Core\Models;

class Device extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
