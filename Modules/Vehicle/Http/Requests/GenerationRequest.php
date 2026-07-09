<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

abstract class GenerationRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'model_id' => ['required', 'integer', Rule::exists('models', 'id')],
            'name' => ['required', 'string', 'max:120'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100', 'gte:start_year'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
