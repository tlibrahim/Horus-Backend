<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\OBD;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\VehicleObdDevice;

/**
 * @mixin VehicleObdDevice
 */
final class VehicleObdDeviceDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'vehicle' => [
                'id' => $this->vehicle->id,
                'plate_number' => $this->vehicle->plate_number,
                'vin' => $this->vehicle->vin,
            ],

            'device' => [
                'id' => $this->obdDevice->id,
                'serial_number' => $this->obdDevice->serial_number,
                'manufacturer' => $this->obdDevice->manufacturer,
                'model' => $this->obdDevice->model,
            ],

            'paired_at' => $this->formatDate($this->paired_at),

            'unpaired_at' => $this->formatDate($this->unpaired_at),

            'is_active' => (bool) $this->is_active,

            'notes' => $this->notes,

            'created_at' => $this->formatDate($this->created_at),

            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
