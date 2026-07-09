<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\Country;

class Brand extends BaseModel
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class, 'brand_id');
    }
}
