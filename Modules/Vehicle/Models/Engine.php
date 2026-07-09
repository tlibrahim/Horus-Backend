<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Engine extends BaseModel
{
    public $timestamps = false;

    public function generation(): BelongsTo
    {
        return $this->belongsTo(Generation::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function transmission(): BelongsTo
    {
        return $this->belongsTo(Transmission::class);
    }
}
