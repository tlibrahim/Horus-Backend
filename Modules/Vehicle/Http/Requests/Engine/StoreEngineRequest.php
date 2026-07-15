<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\Engine;

final class StoreEngineRequest extends EngineRequest
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
