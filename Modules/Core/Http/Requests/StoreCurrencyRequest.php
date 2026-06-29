<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class StoreCurrencyRequest extends BaseRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('currencies', 'code'),
            ],

            'symbol' => [
                'required',
                'string',
                'max:10',
                Rule::unique('currencies', 'symbol'),
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'currency_symbol' => [
                'required',
                'string',
                'max:10',
            ],

            // 'is_default' => [
            //     'sometimes',
            //     'boolean',
            // ],

            // 'is_active' => [
            //     'sometimes',
            //     'boolean',
            // ],
        ];
    }
}
