<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Role;

use Illuminate\Validation\Rule;

final class StoreRoleRequest extends RoleRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            [
                'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')],
                'slug' => ['required', 'string', 'max:100', Rule::unique('roles', 'slug')],
            ],
        );
    }
}
