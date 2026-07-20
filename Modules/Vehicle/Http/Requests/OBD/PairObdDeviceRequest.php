<?php

namespace Backend\Modules\Vehicle\Http\Requests\OBD;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class PairObdDeviceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'obd_device_id' => [
                'required',
                'integer',
                Rule::exists('obd_devices', 'id'),
            ],

            'paired_at' => [
                'nullable',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
