<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

final class UpdateGenerationRequest extends GenerationRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->commonRules();
    }
}
