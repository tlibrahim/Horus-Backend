<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleModel extends BaseModel
{
    protected $table = 'models';

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function generations(): HasMany
    {
        return $this->hasMany(Generation::class, 'model_id');
    }
}
