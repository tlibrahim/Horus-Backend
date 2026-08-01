<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Resources\Sessions;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\OBD\Models\ObdSession;

/**
 * @mixin ObdSession
 */
final class ObdSessionDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'session_uuid' => $this->session_uuid,

            'vehicle_obd_device_id' => $this->vehicle_obd_device_id,

            'connection_type' => $this->connection_type?->value,

            'status' => $this->status?->value,

            'started_at' => $this->formatDate($this->started_at),

            'ended_at' => $this->formatDate($this->ended_at),

            'last_activity_at' => $this->formatDate($this->last_activity_at),

            'ip_address' => $this->ip_address,

            'firmware_version' => $this->firmware_version,

            'metadata' => $this->metadata,

            'created_at' => $this->formatDate($this->created_at),

            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
