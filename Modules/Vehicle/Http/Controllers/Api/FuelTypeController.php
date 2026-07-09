<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\FuelTypeServiceInterface;
use Modules\Vehicle\Http\Resources\FuelTypeDetailsResource;
use Modules\Vehicle\Http\Resources\FuelTypeOptionResource;
use Modules\Vehicle\Http\Resources\FuelTypeResource;
use Modules\Vehicle\Models\FuelType;

final class FuelTypeController extends BaseApiController
{
    public function __construct(
        private readonly FuelTypeServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: FuelTypeResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: FuelTypeOptionResource::collection($this->service->options()),
        );
    }

    public function show(FuelType $fuelType): JsonResponse
    {
        return $this->success(
            data: FuelTypeDetailsResource::make($fuelType),
        );
    }
}
