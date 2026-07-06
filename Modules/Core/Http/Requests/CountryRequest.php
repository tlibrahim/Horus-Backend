<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

abstract class CountryRequest extends BaseRequest
{
    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'iso2' => strtoupper(trim((string) $this->input('iso2'))),
            'iso3' => strtoupper(trim((string) $this->input('iso3'))),
            'phone_code' => trim((string) $this->input('phone_code')),
            'nationality' => trim((string) $this->input('nationality')),
        ]);
    }

    /**
     * Common validation rules.
     *
     * @return array<string, mixed>
     */
    protected function commonRules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone_code' => [
                'required',
                'string',
                'max:10',
            ],

            'currency_id' => [
                'required',
                'integer',
                Rule::exists('currencies', 'id'),
            ],

            'language_id' => [
                'required',
                'integer',
                Rule::exists('languages', 'id'),
            ],

            'timezone_id' => [
                'required',
                'integer',
                Rule::exists('timezones', 'id'),
            ],

            'nationality' => [
                'required',
                'string',
                'max:100',
            ],

            'flag' => [
                'nullable',
                'string',
                'max:255',
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    /**
     * Human-readable attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'iso2' => __('api.attributes.country.iso2'),
            'iso3' => __('api.attributes.country.iso3'),
            'phone_code' => __('api.attributes.country.phone_code'),
            'currency_id' => __('api.attributes.country.currency'),
            'language_id' => __('api.attributes.country.language'),
            'timezone_id' => __('api.attributes.country.timezone'),
            'nationality' => __('api.attributes.country.nationality'),
        ];
    }
}
