<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\VehicleTypeServiceInterface;
use Modules\Vehicle\Http\Resources\VehicleTypeDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleTypeOptionResource;
use Modules\Vehicle\Http\Resources\VehicleTypeResource;
use Modules\Vehicle\Models\VehicleType;

final class VehicleTypeController extends BaseApiController
{
    public function __construct(
        private readonly VehicleTypeServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: VehicleTypeResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: VehicleTypeOptionResource::collection($this->service->options()),
        );
    }

    public function show(VehicleType $vehicleType): JsonResponse
    {
        return $this->success(
            data: VehicleTypeDetailsResource::make($vehicleType),
        );
    }
}
