<?php

declare(strict_types=1);

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\Vehicle\Database\Factories\VehicleImageFactory;

final class VehicleImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function newFactory(): VehicleImageFactory
    {
        return VehicleImageFactory::new();
    }

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

    protected $appends = [
        'url',
        'thumbnail_url',
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

    public function getUrlAttribute(): ?string
    {
        return $this->path ? Storage::disk($this->disk)->url($this->path) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? Storage::disk($this->disk)->url($this->thumbnail_path) : null;
    }
}
