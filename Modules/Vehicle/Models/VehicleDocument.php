<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vehicle\Database\Factories\VehicleDocumentFactory;

class VehicleDocument extends Model
{
    use HasFactory;

    protected static function newFactory(): VehicleDocumentFactory
    {
        return VehicleDocumentFactory::new();
    }

    protected $fillable = [
        'vehicle_id',
        'document_type_id',
        'document_number',
        'issue_date',
        'expiry_date',
        'file_name',
        'original_name',
        'mime_type',
        'size',
        'disk',
        'path',
        'metadata',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'metadata' => 'array',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            VehicleDocumentType::class,
            'document_type_id'
        );
    }
}
