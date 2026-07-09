<?php

namespace Modules\IAM\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends BaseModel
{
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
