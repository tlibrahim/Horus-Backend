<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateLanguageRequest extends BaseRequest
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
        $language = $this->route('language');

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
                Rule::unique('languages', 'code')
                    ->ignore($language),
            ],

            'direction' => [
                'required',
                'string',
                Rule::in(['ltr', 'rtl']),
            ],
        ];
    }
}
