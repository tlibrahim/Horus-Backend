<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Role;

use Illuminate\Validation\Rule;

final class UpdateRoleRequest extends RoleRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $role = $this->route('role');
        $roleId = is_object($role) ? $role->getKey() : $role;

        return array_merge(
            $this->commonRules(),
            [
                'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($roleId)],
                'slug' => ['required', 'string', 'max:100', Rule::unique('roles', 'slug')->ignore($roleId)],
            ],
        );
    }
}
