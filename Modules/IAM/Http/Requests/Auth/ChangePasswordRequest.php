<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class ChangePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
