<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Permission;

use Illuminate\Validation\Rule;

final class UpdatePermissionRequest extends PermissionRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permission = $this->route('permission');
        $permissionId = is_object($permission) ? $permission->getKey() : $permission;

        return array_merge(
            $this->commonRules(),
            [
                'slug' => ['required', 'string', 'max:150', Rule::unique('permissions', 'slug')->ignore($permissionId)],
            ],
        );
    }
}
