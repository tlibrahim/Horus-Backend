<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Requests\Permission;

use Illuminate\Validation\Rule;

final class StorePermissionRequest extends PermissionRequest
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
                'slug' => ['required', 'string', 'max:150', Rule::unique('permissions', 'slug')],
            ],
        );
    }
}
