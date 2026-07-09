<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Role;

use App\Support\Http\Requests\BaseRequest;

final class UpdateRoleStatusRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active' => ['required', 'boolean'],
        ];
    }
}
