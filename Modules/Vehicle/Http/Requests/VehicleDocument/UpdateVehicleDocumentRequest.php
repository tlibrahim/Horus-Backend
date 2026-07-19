<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Requests\VehicleDocument;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Modules\Vehicle\Models\VehicleDocumentType;

final class UpdateVehicleDocumentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'document_type_id' => [
                'sometimes',
                Rule::exists('vehicle_document_types', 'id')
                    ->where('is_active', true),
            ],

            'document_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'issue_date' => [
                'nullable',
                'date',
            ],

            'expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:issue_date',
            ],

        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {

            $documentTypeId = $this->input('document_type_id');

            if ($documentTypeId === null) {
                return;
            }

            $type = VehicleDocumentType::find($documentTypeId);

            if ($type === null) {
                return;
            }

            if (
                $type->requires_number &&
                blank($this->input('document_number'))
            ) {
                $validator->errors()->add(
                    'document_number',
                    'The document number field is required.'
                );
            }

            if (
                $type->requires_expiry &&
                blank($this->input('expiry_date'))
            ) {
                $validator->errors()->add(
                    'expiry_date',
                    'The expiry date field is required.'
                );
            }
        });
    }
}
