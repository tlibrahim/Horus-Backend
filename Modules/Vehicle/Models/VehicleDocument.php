<?php

namespace Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'document_type_id',
        'document_number',
        'issue_date',
        'expiry_date',
        'issuer',
        'notes',
        'file_name',
        'original_name',
        'mime_type',
        'size',
        'disk',
        'path',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'metadata' => 'array',
        ];
    }

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
