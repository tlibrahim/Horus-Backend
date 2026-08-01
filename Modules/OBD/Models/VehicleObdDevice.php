<?php

namespace Modules\OBD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\OBD\Database\Factories\VehicleObdDeviceFactory;
use Modules\Vehicle\Models\Vehicle;

class VehicleObdDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'obd_device_id',
        'paired_at',
        'unpaired_at',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'paired_at' => 'datetime',
        'unpaired_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function newFactory(): VehicleObdDeviceFactory
    {
        return VehicleObdDeviceFactory::new();
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function obdDevice(): BelongsTo
    {
        return $this->belongsTo(ObdDevice::class);
    }
}
