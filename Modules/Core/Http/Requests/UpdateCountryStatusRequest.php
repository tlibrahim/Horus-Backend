<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use App\Support\Http\Requests\BaseRequest;

final class UpdateCountryStatusRequest extends BaseRequest
{
    /**
     * Determine whether the user can perform this request.
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
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'is_active.required' => __('validation.required', [
                'attribute' => 'status',
            ]),
            'is_active.boolean' => __('validation.boolean', [
                'attribute' => 'status',
            ]),
        ];
    }
}
