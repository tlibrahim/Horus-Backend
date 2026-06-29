<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Core\Database\Factories\UserFactory;
use Modules\Core\Traits\HasUuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use HasUuid;
    use SoftDeletes;

    protected $guarded = [];

    protected string $guard_name = 'api';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | Future Modules
    |--------------------------------------------------------------------------
    */

    // public function vehicles()
    // {
    //     return $this->hasMany(\Modules\Vehicle\Models\Vehicle::class);
    // }

    // public function notifications()
    // {
    //     return $this->hasMany(\Modules\Notification\Models\Notification::class);
    // }
}
