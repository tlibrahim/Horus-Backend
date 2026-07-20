<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\OBD;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdDeviceStatus;

final class StoreObdDeviceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number' => [
                'required',
                'string',
                'max:100',
                'unique:obd_devices,serial_number',
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
                'sometimes',
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

    protected function prepareForValidation(): void
    {
        if ($this->filled('serial_number')) {
            $this->merge([
                'serial_number' => strtoupper(trim((string) $this->serial_number)),
            ]);
        }
    }
}
