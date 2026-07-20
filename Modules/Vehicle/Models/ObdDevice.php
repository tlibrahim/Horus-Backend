<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vehicle\Database\Factories\ObdDeviceFactory;

class ObdDevice extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'serial_number',
        'manufacturer',
        'model',
        'firmware_version',
        'hardware_version',
        'connection_type',
        'status',
        'mac_address',
        'imei',
        'sim_number',
        'metadata',
        'last_seen_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'last_seen_at' => 'datetime',
    ];

    protected static function newFactory(): ObdDeviceFactory
    {
        return ObdDeviceFactory::new();
    }

    public function vehicleAssignments(): HasMany
    {
        return $this->hasMany(VehicleObdDevice::class);
    }
}
