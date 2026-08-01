<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\OBD\Models\ObdDevice;

/**
 * @mixin ObdDevice
 */
final class ObdDeviceDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'serial_number' => $this->serial_number,

            'manufacturer' => $this->manufacturer,
            'model' => $this->model,

            'firmware_version' => $this->firmware_version,
            'hardware_version' => $this->hardware_version,

            'connection_type' => $this->connection_type,
            'status' => $this->status,

            'mac_address' => $this->mac_address,
            'imei' => $this->imei,
            'sim_number' => $this->sim_number,

            'metadata' => $this->metadata,

            'last_seen_at' => $this->formatDate($this->last_seen_at),

            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
