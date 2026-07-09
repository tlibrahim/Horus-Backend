<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

use Illuminate\Validation\Rule;

final class StoreVehicleModelRequest extends VehicleModelRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->commonRules(),
            [
                'slug' => ['required', 'string', 'max:140', Rule::unique('models', 'slug')],
            ],
        );
    }
}
