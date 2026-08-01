<?php

declare(strict_types=1);

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Auth\Models\User;
use Modules\Vehicle\Database\Factories\VehicleOwnerFactory;

final class VehicleOwner extends Model
{
    use HasFactory;

    protected static function newFactory(): VehicleOwnerFactory
    {
        return VehicleOwnerFactory::new();
    }

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'ownership_type',
        'is_primary',
        'ownership_percentage',
        'started_at',
        'ended_at',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'ownership_percentage' => 'decimal:2',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->ended_at === null;
    }

    public function isExpired(): bool
    {
        return $this->ended_at !== null;
    }
}
