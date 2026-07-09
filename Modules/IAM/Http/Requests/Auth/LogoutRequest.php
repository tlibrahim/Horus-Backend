<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class LogoutRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'refresh_token' => ['nullable', 'uuid'],
        ];
    }
}
