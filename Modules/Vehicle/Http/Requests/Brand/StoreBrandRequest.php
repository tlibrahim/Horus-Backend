<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\Brand;

use Illuminate\Validation\Rule;

final class StoreBrandRequest extends BrandRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            [
                'slug' => [
                    'required',
                    'string',
                    'max:120',
                    Rule::unique('brands', 'slug'),
                ],
            ],
        );
    }
}
