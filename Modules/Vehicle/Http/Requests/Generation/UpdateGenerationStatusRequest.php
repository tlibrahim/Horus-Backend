<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\Generation;

use App\Support\Http\Requests\BaseRequest;

final class UpdateGenerationStatusRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active' => ['required', 'boolean'],
        ];
    }
}
