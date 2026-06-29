<?php

declare(strict_types=1);

namespace App\Support\Http\Requests;

use App\Support\Enums\ProblemType;
use App\Support\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validated request data.
     */
    public function validatedData(): array
    {
        return $this->validated();
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Custom validation attribute names.
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        //
    }

    /**
     * Handle the request after validation has passed.
     */
    protected function passedValidation(): void
    {
        //
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            ApiResponse::error(
                type: ProblemType::Validation,
                detail: __('api.errors.validation.detail'),
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
                errors: $validator->errors()->toArray(),
            )
        );
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            __('api.errors.forbidden.detail')
        );
    }
}
