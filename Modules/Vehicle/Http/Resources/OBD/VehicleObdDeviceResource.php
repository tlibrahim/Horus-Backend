<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\OBD;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\VehicleObdDevice;

/**
 * @mixin VehicleObdDevice
 */
final class VehicleObdDeviceResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'vehicle_id' => $this->vehicle_id,

            'obd_device_id' => $this->obd_device_id,

            'paired_at' => $this->formatDate($this->paired_at),

            'unpaired_at' => $this->formatDate($this->unpaired_at),

            'is_active' => (bool) $this->is_active,

            'notes' => $this->notes,
        ];
    }
}
