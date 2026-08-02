<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests\FeatureFlags;

use App\Support\Http\Requests\BaseRequest;

final class StoreFeatureFlagRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                'max:255',
                'unique:feature_flags,key',
            ],

            'enabled' => [
                'sometimes',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
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
    }
}
