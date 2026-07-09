<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'device_uuid' => ['nullable', 'uuid'],
            'platform' => ['nullable', 'string', 'max:50'],
            'device_name' => ['nullable', 'string', 'max:100'],
            'os_version' => ['nullable', 'string', 'max:50'],
            'app_version' => ['nullable', 'string', 'max:50'],
        ];
    }
}
