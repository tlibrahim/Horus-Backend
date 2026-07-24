<?php

// declare(strict_types=1);

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Modules\Vehicle\Database\Factories\ObdSessionFactory;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdSessionStatus;

class ObdSession extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'vehicle_obd_device_id',
        'session_uuid',
        'connection_type',
        'status',
        'started_at',
        'ended_at',
        'last_activity_at',
        'ip_address',
        'firmware_version',
        'metadata',
    ];

    protected $casts = [
        'connection_type' => ConnectionType::class,
        'status' => ObdSessionStatus::class,

        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'last_activity_at' => 'datetime',

        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $session): void {
            if (blank($session->session_uuid)) {
                $session->session_uuid = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory(): ObdSessionFactory
    {
        return ObdSessionFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function vehicleObdDevice(): BelongsTo
    {
        return $this->belongsTo(VehicleObdDevice::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            ObdSessionStatus::Connecting,
            ObdSessionStatus::Connected,
        ]);
    }

    public function scopeConnected($query)
    {
        return $query->where(
            'status',
            ObdSessionStatus::Connected,
        );
    }

    public function scopeDisconnected($query)
    {
        return $query->where(
            'status',
            ObdSessionStatus::Disconnected,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isConnected(): bool
    {
        return $this->status === ObdSessionStatus::Connected;
    }

    public function isConnecting(): bool
    {
        return $this->status === ObdSessionStatus::Connecting;
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isClosed(): bool
    {
        return $this->status->isClosed();
    }
}
