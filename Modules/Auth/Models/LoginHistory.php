<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginHistory extends BaseModel
{
    protected function casts(): array
    {
        return [
            'is_success' => 'boolean',
            'logged_in_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userDevice(): BelongsTo
    {
        return $this->belongsTo(UserDevice::class);
    }
}
