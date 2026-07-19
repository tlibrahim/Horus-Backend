<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleOwner;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\IAM\Models\User;
use Modules\Vehicle\Enums\OwnershipType;

final class StoreVehicleOwnerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists(
                    (new User)->getTable(),
                    'id',
                ),
            ],

            'ownership_type' => [
                'required',
                new Enum(OwnershipType::class),
            ],

            'is_primary' => [
                'sometimes',
                'boolean',
            ],

            'ownership_percentage' => [
                'nullable',
                'numeric',
                'between:0,100',
            ],

            'started_at' => [
                'nullable',
                'date',
            ],

            'ended_at' => [
                'nullable',
                'date',
                'after_or_equal:started_at',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
