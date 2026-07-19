<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleDocument;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Modules\Vehicle\Models\VehicleDocument;

/**
 * @mixin VehicleDocument
 */
final class VehicleDocumentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'vehicle_id' => $this->vehicle_id,

            'document_type' => [
                'id' => $this->documentType?->id,
                'name' => $this->documentType?->name,
                'slug' => $this->documentType?->slug,
            ],

            'document_number' => $this->document_number,

            'issue_date' => $this->issue_date?->toDateString(),

            'expiry_date' => $this->expiry_date?->toDateString(),

            'is_expired' => $this->expiry_date?->isPast() ?? false,

            'file' => [
                'disk' => $this->disk,
                'path' => $this->path,
                'file_name' => $this->file_name,
                'original_name' => $this->original_name,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'url' => $this->path
                    ? Storage::disk($this->disk)->url($this->path)
                    : null,
            ],

            'metadata' => $this->metadata,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
