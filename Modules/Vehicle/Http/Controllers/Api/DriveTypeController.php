<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\DriveTypeServiceInterface;
use Modules\Vehicle\Http\Resources\DriveTypeDetailsResource;
use Modules\Vehicle\Http\Resources\DriveTypeOptionResource;
use Modules\Vehicle\Http\Resources\DriveTypeResource;
use Modules\Vehicle\Models\DriveType;

final class DriveTypeController extends BaseApiController
{
    public function __construct(
        private readonly DriveTypeServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: DriveTypeResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: DriveTypeOptionResource::collection($this->service->options()),
        );
    }

    public function show(DriveType $driveType): JsonResponse
    {
        return $this->success(
            data: DriveTypeDetailsResource::make($driveType),
        );
    }
}
