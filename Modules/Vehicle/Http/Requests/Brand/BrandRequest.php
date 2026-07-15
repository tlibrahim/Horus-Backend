<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\Brand;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

abstract class BrandRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));

        $this->merge([
            'name' => $name,
            'slug' => Str::slug((string) $this->input('slug', $name)),
            'logo' => $this->input('logo') !== null
                ? trim((string) $this->input('logo'))
                : null,
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:120'],
            'logo' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'integer', Rule::exists('countries', 'id')],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
