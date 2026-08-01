<?php

namespace Modules\OBD\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\OBD\Enums\ConnectionType;
use Modules\OBD\Enums\ObdDeviceStatus;

final class UpdateObdDeviceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $obdDevice = $this->route('obdDevice');

        return [
            'serial_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('obd_devices', 'serial_number')
                    ->ignore($obdDevice),
            ],

            'manufacturer' => [
                'required',
                'string',
                'max:100',
            ],

            'model' => [
                'required',
                'string',
                'max:100',
            ],

            'firmware_version' => [
                'nullable',
                'string',
                'max:50',
            ],

            'hardware_version' => [
                'nullable',
                'string',
                'max:50',
            ],

            'connection_type' => [
                'required',
                Rule::enum(ConnectionType::class),
            ],

            'status' => [
                'required',
                Rule::enum(ObdDeviceStatus::class),
            ],

            'mac_address' => [
                'nullable',
                'string',
                'max:50',
            ],

            'imei' => [
                'nullable',
                'string',
                'max:20',
            ],

            'sim_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'metadata' => [
                'nullable',
                'array',
            ],

            'last_seen_at' => [
                'nullable',
                'date',
            ],
        ];
    }
}
