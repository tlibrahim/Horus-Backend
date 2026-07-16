<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleDocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'requires_expiry',
        'requires_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'requires_expiry' => 'boolean',
            'requires_number' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(VehicleDocument::class, 'document_type_id');
    }
}
