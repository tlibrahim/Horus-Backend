<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Requests\Sessions;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\OBD\Enums\ConnectionType;
use Modules\OBD\Enums\ObdSessionStatus;

final class StoreObdSessionRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'vehicle_obd_device_id' => [
                'required',
                'integer',
                Rule::exists('vehicle_obd_devices', 'id'),
            ],

            'connection_type' => [
                'required',
                Rule::in(ConnectionType::values()),
            ],

            'status' => [
                'sometimes',
                Rule::in(ObdSessionStatus::values()),
            ],

            'started_at' => [
                'nullable',
                'date',
            ],

            'ip_address' => [
                'nullable',
                'ip',
            ],

            'firmware_version' => [
                'nullable',
                'string',
                'max:100',
            ],

            'metadata' => [
                'nullable',
                'array',
            ],
        ];
    }
}
