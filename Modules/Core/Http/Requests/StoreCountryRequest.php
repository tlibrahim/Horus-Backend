<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use Illuminate\Validation\Rule;

final class StoreCountryRequest extends CountryRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            [
                'iso2' => [
                    'required',
                    'string',
                    'size:2',
                    Rule::unique('countries', 'iso2'),
                ],

                'iso3' => [
                    'required',
                    'string',
                    'size:3',
                    Rule::unique('countries', 'iso3'),
                ],
            ],
        );
    }
}
