<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vehicle\Database\Factories\VehicleDocumentTypeFactory;

class VehicleDocumentType extends Model
{
    use HasFactory;

    protected static function newFactory(): VehicleDocumentTypeFactory
    {
        return VehicleDocumentTypeFactory::new();
    }

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
