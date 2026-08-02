<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests\FeatureFlags;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateFeatureFlagRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('feature_flags', 'key')
                    ->ignore($this->route('feature_flag')),
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
