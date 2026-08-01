<?php

namespace Modules\OBD\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\OBD\Database\Factories\ObdDeviceFactory;
use Modules\Vehicle\Models\BaseModel;

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

    public function activeVehicleAssignment(): HasOne
    {
        return $this->hasOne(VehicleObdDevice::class)
            ->where('is_active', true);
    }
}
