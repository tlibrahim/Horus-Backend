<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageServiceInterface;
use Modules\Vehicle\Http\Requests\VehicleImage\StoreVehicleImageRequest;
use Modules\Vehicle\Http\Requests\VehicleImage\UpdateVehicleImageRequest;
use Modules\Vehicle\Http\Resources\VehicleImage\VehicleImageDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleImage\VehicleImageResource;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleImage;
use Symfony\Component\HttpFoundation\Response;

final class VehicleImageController extends BaseApiController
{
    public function __construct(
        private readonly VehicleImageServiceInterface $service,
    ) {}

    /**
     * List images for a vehicle.
     */
    public function index(Vehicle $vehicle): JsonResponse
    {
        return $this->success(
            data: VehicleImageResource::collection(
                $vehicle->images()
                    ->orderBy('sort_order')
                    ->get()
            ),
        );
    }

    /**
     * Upload image.
     */
    public function store(StoreVehicleImageRequest $request, Vehicle $vehicle): JsonResponse
    {
        $image = $this->service->create(
            vehicle: $vehicle,
            image: $request->file('image'),
            attributes: $request->validated(),
        );

        return $this->created(
            data: VehicleImageDetailsResource::make($image),
        );
    }

    /**
     * Show image.
     */
    public function show(VehicleImage $vehicleImage): JsonResponse
    {
        return $this->success(
            data: VehicleImageDetailsResource::make(
                $vehicleImage,
            ),
        );
    }

    /**
     * Update metadata.
     */
    public function update(UpdateVehicleImageRequest $request, VehicleImage $vehicleImage): JsonResponse
    {
        return $this->success(
            data: VehicleImageDetailsResource::make(
                $this->service->update(
                    $vehicleImage,
                    $request->validated(),
                ),
            ),
        );
    }

    /**
     * Delete image.
     */
    public function destroy(VehicleImage $vehicleImage): Response
    {
        $this->service->delete($vehicleImage);

        return $this->noContent();
    }
}
