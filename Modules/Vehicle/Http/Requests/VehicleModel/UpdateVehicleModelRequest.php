<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleModel;

use Illuminate\Validation\Rule;

final class UpdateVehicleModelRequest extends VehicleModelRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehicleModel = $this->route('vehicleModel');

        $vehicleModelId = is_object($vehicleModel)
            ? $vehicleModel->getKey()
            : $vehicleModel;

        return array_merge(
            $this->commonRules(),
            [
                'slug' => [
                    'required',
                    'string',
                    'max:140',
                    Rule::unique('models', 'slug')->ignore($vehicleModelId),
                ],
            ],
        );
    }
}
