<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\OBD\Sessions;

use App\Support\Http\Requests\BaseRequest;

final class UpdateObdSessionStatusRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'is_active' => [
                'required',
                'boolean',
            ],

        ];
    }
}
