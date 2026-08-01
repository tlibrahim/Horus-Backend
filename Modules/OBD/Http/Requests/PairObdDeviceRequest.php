<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Requests;

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

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
