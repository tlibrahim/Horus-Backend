<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Role;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class SyncRolePermissionsRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', Rule::exists('permissions', 'id')],
        ];
    }
}
