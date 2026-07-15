<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleImage;

use App\Support\Http\Requests\BaseRequest;

final class StoreVehicleImageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'is_primary' => [
                'sometimes',
                'boolean',
            ],

            'sort_order' => [
                'sometimes',
                'integer',
                'min:0',
            ],
        ];
    }
}
