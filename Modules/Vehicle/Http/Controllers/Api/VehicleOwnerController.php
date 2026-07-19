<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\VehicleOwner\VehicleOwnerServiceInterface;
use Modules\Vehicle\Http\Requests\VehicleOwner\StoreVehicleOwnerRequest;
use Modules\Vehicle\Http\Requests\VehicleOwner\UpdateVehicleOwnerRequest;
use Modules\Vehicle\Http\Resources\VehicleOwner\VehicleOwnerDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleOwner\VehicleOwnerResource;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;
use Symfony\Component\HttpFoundation\Response;

final class VehicleOwnerController extends BaseApiController
{
    public function __construct(
        private readonly VehicleOwnerServiceInterface $service,
    ) {}

    /**
     * List vehicle owners.
     */
    public function index(
        Vehicle $vehicle,
    ): JsonResponse {
        return $this->success(
            VehicleOwnerResource::collection(
                $this->service->byVehicle($vehicle)
            )
        );
    }

    /**
     * Create vehicle owner.
     */
    public function store(
        StoreVehicleOwnerRequest $request,
        Vehicle $vehicle,
    ): JsonResponse {
        $owner = $this->service->create(
            vehicle: $vehicle,
            attributes: $request->validated(),
        );

        return $this->created(
            data: VehicleOwnerDetailsResource::make($owner),
        );
    }

    /**
     * Show vehicle owner.
     */
    public function show(
        VehicleOwner $vehicleOwner,
    ): JsonResponse {
        return $this->success(
            data: VehicleOwnerDetailsResource::make(
                $vehicleOwner,
            ),
        );
    }

    /**
     * Update vehicle owner.
     */
    public function update(
        UpdateVehicleOwnerRequest $request,
        VehicleOwner $vehicleOwner,
    ): JsonResponse {
        $owner = $this->service->update(
            ownership: $vehicleOwner,
            attributes: $request->validated(),
        );

        return $this->success(
            data: VehicleOwnerDetailsResource::make($owner),
        );
    }

    /**
     * Delete vehicle owner.
     */
    public function destroy(
        VehicleOwner $vehicleOwner,
    ): Response {
        $this->service->delete($vehicleOwner);

        return $this->noContent();
    }
}
