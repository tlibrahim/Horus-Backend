<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

abstract class EngineRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => strtoupper(trim((string) $this->input('code'))),
            'name' => trim((string) $this->input('name')),
        ]);
    }

    protected function commonRules(): array
    {
        return [
            'generation_id' => ['required', 'integer', Rule::exists('generations', 'id')],
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'displacement' => ['nullable', 'numeric', 'between:0.1,9.9'],
            'horse_power' => ['nullable', 'integer', 'min:1', 'max:2000'],
            'torque' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'fuel_type_id' => ['required', 'integer', Rule::exists('fuel_types', 'id')],
            'transmission_id' => ['required', 'integer', Rule::exists('transmissions', 'id')],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
