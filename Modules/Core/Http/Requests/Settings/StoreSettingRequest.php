<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests\Settings;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class StoreSettingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                'max:255',
                'unique:settings,key',
            ],

            'group' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
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
                'boolean',
            ],
        ];
    }
}
