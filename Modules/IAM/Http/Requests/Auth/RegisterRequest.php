<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'display_name' => ['nullable', 'string', 'max:200'],
            'mobile' => ['required', 'string', 'max:30', Rule::unique('users', 'mobile')],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
