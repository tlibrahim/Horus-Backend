<?php

declare(strict_types=1);

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class VehicleImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vehicle_images';

    protected $fillable = [
        'vehicle_id',
        'disk',
        'path',
        'thumbnail_path',
        'original_name',
        'mime_type',
        'size',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'size' => 'integer',
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
