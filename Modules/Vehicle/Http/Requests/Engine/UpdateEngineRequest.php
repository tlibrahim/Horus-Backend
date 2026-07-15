<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\Engine;

final class UpdateEngineRequest extends EngineRequest
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
