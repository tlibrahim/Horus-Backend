<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleDocument;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Support\Facades\Storage;

final class VehicleDocumentResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'document_type_id' => $this->document_type_id,

            'document_number' => $this->document_number,

            'issue_date' => $this->issue_date,

            'expiry_date' => $this->expiry_date,

            'file' => [
                'name' => $this->original_name,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'disk' => $this->disk,
                'path' => $this->path,

                'url' => $this->path
                    ? Storage::disk($this->disk)->url($this->path)
                    : null,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
