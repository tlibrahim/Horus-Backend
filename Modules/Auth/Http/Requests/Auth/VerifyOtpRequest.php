<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class VerifyOtpRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:30'],
            'code' => ['required', 'string', 'max:10'],
            'purpose' => ['required', 'string', 'in:register,login,forgot_password'],
        ];
    }
}
