<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Role;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Support\Str;

abstract class RoleRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));

        $this->merge([
            'name' => $name,
            'slug' => Str::slug((string) $this->input('slug', $name)),
            'description' => $this->input('description') !== null
                ? trim((string) $this->input('description'))
                : null,
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_system' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
