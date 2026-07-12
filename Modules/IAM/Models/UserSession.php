<?php

namespace Modules\IAM\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSession extends BaseModel
{
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'revoked_at' => 'datetime',
            'logout_at' => 'datetime',
            'remember_me' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(UserDevice::class, 'device_id');
    }

    public function refreshTokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }
}
