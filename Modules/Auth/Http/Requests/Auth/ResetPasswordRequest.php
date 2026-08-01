<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class ResetPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:30'],
            'code' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
