<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests\Settings;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateSettingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('settings', 'key')
                    ->ignore($this->route('setting')),
            ],

            'group' => [
                'sometimes',
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'sometimes',
                'required',
                Rule::in([
                    'string',
                    'integer',
                    'float',
                    'boolean',
                    'array',
                    'object',
                    'json',
                ]),
            ],

            'value' => [
                'nullable',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_public' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('key')) {
            $this->merge([
                'key' => trim((string) $this->input('key')),
            ]);
        }

        if ($this->has('group')) {
            $this->merge([
                'group' => trim((string) $this->input('group')),
            ]);
        }
    }
}
