<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class ForgotPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:30'],
        ];
    }
}
