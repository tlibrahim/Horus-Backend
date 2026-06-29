<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class StoreLanguageRequest extends BaseRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('languages', 'code'),
            ],

            'direction' => [
                'required',
                'string',
                Rule::in(['ltr', 'rtl']),
            ],
        ];
    }
}
