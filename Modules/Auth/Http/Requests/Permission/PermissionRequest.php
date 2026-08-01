<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Permission;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Support\Str;

abstract class PermissionRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));

        $this->merge([
            'name' => $name,
            'code' => trim((string) $this->input('code', $name)),
            'group' => Str::lower(trim((string) $this->input('group'))),
            'description' => $this->input('description') !== null
                ? trim((string) $this->input('description'))
                : null,
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:150'],
            'group' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ];
    }
}
