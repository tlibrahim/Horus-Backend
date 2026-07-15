<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class StoreVehicleRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],

            'brand_id' => [
                'required',
                'integer',
                'exists:brands,id',
            ],

            'model_id' => [
                'required',
                'integer',
                'exists:models,id',
            ],

            'generation_id' => [
                'nullable',
                'integer',
                'exists:generations,id',
            ],

            'engine_id' => [
                'nullable',
                'integer',
                'exists:engines,id',
            ],

            'body_type_id' => [
                'required',
                'integer',
                'exists:body_types,id',
            ],

            'drive_type_id' => [
                'required',
                'integer',
                'exists:drive_types,id',
            ],

            'vehicle_type_id' => [
                'required',
                'integer',
                'exists:vehicle_types,id',
            ],

            'vin' => [
                'nullable',
                'string',
                'size:17',
                Rule::unique('vehicles'),
            ],

            'plate_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'manufacture_year' => [
                'required',
                'integer',
                'min:1950',
                'max:'.(date('Y') + 1),
            ],

            'current_mileage' => [
                'required',
                'integer',
                'min:0',
            ],

            'color' => [
                'nullable',
                'string',
                'max:50',
            ],

            'is_primary' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
