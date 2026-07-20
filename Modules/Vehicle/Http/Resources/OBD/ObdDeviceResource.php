<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\OBD;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\ObdDevice;

/**
 * @mixin ObdDevice
 */
final class ObdDeviceResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'connection_type' => $this->connection_type,
            'status' => $this->status,
            'last_seen_at' => $this->formatDate($this->last_seen_at),
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
