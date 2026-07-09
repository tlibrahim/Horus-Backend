<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Generation extends BaseModel
{
    public $timestamps = false;

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function engines(): HasMany
    {
        return $this->hasMany(Engine::class, 'generation_id');
    }
}
