<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentServiceInterface;
use Modules\Vehicle\Http\Requests\VehicleDocument\StoreVehicleDocumentRequest;
use Modules\Vehicle\Http\Requests\VehicleDocument\UpdateVehicleDocumentRequest;
use Modules\Vehicle\Http\Resources\VehicleDocument\VehicleDocumentDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleDocument\VehicleDocumentResource;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleDocument;
use Symfony\Component\HttpFoundation\Response;

final class VehicleDocumentController extends BaseApiController
{
    public function __construct(
        private readonly VehicleDocumentServiceInterface $service,
    ) {}

    /**
     * List documents for a vehicle.
     */
    public function index(Vehicle $vehicle): JsonResponse
    {
        return $this->success(
            data: VehicleDocumentResource::collection(
                $vehicle->documents()
                    ->latest()
                    ->get()
            ),
        );
    }

    /**
     * Upload document.
     */
    public function store(
        StoreVehicleDocumentRequest $request,
        Vehicle $vehicle,
    ): JsonResponse {
        $document = $this->service->create(
            vehicle: $vehicle,
            file: $request->file('file'),
            attributes: $request->validated(),
        );

        return $this->created(
            data: VehicleDocumentDetailsResource::make($document),
        );
    }

    /**
     * Show document.
     */
    public function show(
        VehicleDocument $vehicleDocument,
    ): JsonResponse {
        return $this->success(
            data: VehicleDocumentDetailsResource::make(
                $vehicleDocument,
            ),
        );
    }

    /**
     * Update document metadata.
     */
    public function update(
        UpdateVehicleDocumentRequest $request,
        VehicleDocument $vehicleDocument,
    ): JsonResponse {
        return $this->success(
            data: VehicleDocumentDetailsResource::make(
                $this->service->update(
                    $vehicleDocument,
                    $request->validated(),
                ),
            ),
        );
    }

    /**
     * Delete document.
     */
    public function destroy(
        VehicleDocument $vehicleDocument,
    ): Response {
        $this->service->delete($vehicleDocument);

        return $this->noContent();
    }
}
