<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use Illuminate\Validation\Rule;

final class UpdateCountryRequest extends CountryRequest
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
        $country = $this->route('country');

        $countryId = is_object($country) ? $country->getKey() : $country;

        return array_merge(
            $this->commonRules(),
            [
                'iso2' => [
                    'required',
                    'string',
                    'size:2',
                    Rule::unique('countries', 'iso2')->ignore($countryId),
                ],

                'iso3' => [
                    'required',
                    'string',
                    'size:3',
                    Rule::unique('countries', 'iso3')->ignore($countryId),
                ],
            ],
        );
    }
}
