<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleImage;

use App\Support\Http\Requests\BaseRequest;

final class UpdateVehicleImageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
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
