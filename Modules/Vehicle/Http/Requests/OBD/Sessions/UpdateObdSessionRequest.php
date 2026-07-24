<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\OBD\Sessions;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdSessionStatus;

final class UpdateObdSessionRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'connection_type' => [
                'sometimes',
                Rule::in(ConnectionType::values()),
            ],

            'status' => [
                'sometimes',
                Rule::in(ObdSessionStatus::values()),
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
