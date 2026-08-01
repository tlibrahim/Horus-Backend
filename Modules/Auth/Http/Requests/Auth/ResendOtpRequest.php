<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class ResendOtpRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:30'],
            'purpose' => ['required', 'string', 'in:register,login,forgot_password'],
        ];
    }
}
