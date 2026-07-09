<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

use Illuminate\Validation\Rule;

final class UpdateBrandRequest extends BrandRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brand = $this->route('brand');

        $brandId = is_object($brand) ? $brand->getKey() : $brand;

        return array_merge(
            $this->commonRules(),
            [
                'slug' => [
                    'required',
                    'string',
                    'max:120',
                    Rule::unique('brands', 'slug')->ignore($brandId),
                ],
            ],
        );
    }
}
