<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\VehicleServiceInterface;
use Modules\Vehicle\Http\Requests\StoreVehicleRequest;
use Modules\Vehicle\Http\Requests\UpdateVehicleRequest;
use Modules\Vehicle\Http\Resources\VehicleDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleOptionResource;
use Modules\Vehicle\Http\Resources\VehicleResource;
use Modules\Vehicle\Models\Vehicle;
use Symfony\Component\HttpFoundation\Response;

final class VehicleController extends BaseApiController
{
    public function __construct(
        private readonly VehicleServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: VehicleResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: VehicleOptionResource::collection($this->service->options()),
        );
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return $this->success(
            data: VehicleDetailsResource::make(
                $this->service->find($vehicle->getKey()),
            ),
        );
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        return $this->created(
            data: VehicleResource::make(
                $this->service->create(
                    $request->validated(),
                ),
            ),
        );
    }

    public function update(
        UpdateVehicleRequest $request,
        Vehicle $vehicle,
    ): JsonResponse {
        return $this->success(
            data: VehicleResource::make(
                $this->service->update(
                    $vehicle,
                    $request->validated(),
                ),
            ),
        );
    }

    public function destroy(Vehicle $vehicle): Response
    {
        $this->service->delete($vehicle);

        return $this->noContent();
    }
}
