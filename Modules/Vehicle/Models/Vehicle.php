<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Database\Factories\VehicleFactory;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vehicles';

    protected $fillable = [
        'user_id',
        'brand_id',
        'model_id',
        'generation_id',
        'engine_id',
        'body_type_id',
        'drive_type_id',
        'vehicle_type_id',
        'vin',
        'plate_number',
        'manufacture_year',
        'current_mileage',
        'color',
        'is_primary',
    ];

    protected $casts = [
        'manufacture_year' => 'integer',
        'current_mileage' => 'integer',
        'is_primary' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    protected static function newFactory()
    {
        return VehicleFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function generation(): BelongsTo
    {
        return $this->belongsTo(Generation::class);
    }

    public function engine(): BelongsTo
    {
        return $this->belongsTo(Engine::class);
    }

    public function bodyType(): BelongsTo
    {
        return $this->belongsTo(BodyType::class);
    }

    public function driveType(): BelongsTo
    {
        return $this->belongsTo(DriveType::class);
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function owners(): HasMany
    {
        return $this->hasMany(VehicleOwner::class);
    }

    public function obdDevices(): HasMany
    {
        return $this->hasMany(VehicleObdDevice::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(VehicleService::class);
    }

    public function activeObdDevice(): HasOne
    {
        return $this->hasOne(VehicleObdDevice::class)->where('is_active', true);
    }
}
