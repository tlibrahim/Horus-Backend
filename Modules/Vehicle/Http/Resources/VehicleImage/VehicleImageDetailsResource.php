<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\VehicleImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

final class VehicleImageDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'vehicle_id' => $this->vehicle_id,

            'disk' => $this->disk,

            'path' => $this->path,

            'url' => Storage::disk($this->disk)->url($this->path),

            'thumbnail_path' => $this->thumbnail_path,

            'thumbnail_url' => $this->thumbnail_path
                ? Storage::disk($this->disk)->url($this->thumbnail_path)
                : null,

            'original_name' => $this->original_name,

            'mime_type' => $this->mime_type,

            'size' => $this->size,

            'sort_order' => $this->sort_order,

            'is_primary' => $this->is_primary,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
