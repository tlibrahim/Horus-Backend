<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleModel;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

abstract class VehicleModelRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));

        $this->merge([
            'name' => $name,
            'slug' => Str::slug((string) $this->input('slug', $name)),
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'brand_id' => ['required', 'integer', Rule::exists('brands', 'id')],
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
