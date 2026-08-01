<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Requests;

use App\Support\Http\Requests\BaseRequest;

final class UnpairObdDeviceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
