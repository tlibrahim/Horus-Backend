<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\TransmissionServiceInterface;
use Modules\Vehicle\Http\Resources\TransmissionDetailsResource;
use Modules\Vehicle\Http\Resources\TransmissionOptionResource;
use Modules\Vehicle\Http\Resources\TransmissionResource;
use Modules\Vehicle\Models\Transmission;

final class TransmissionController extends BaseApiController
{
    public function __construct(
        private readonly TransmissionServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: TransmissionResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: TransmissionOptionResource::collection($this->service->options()),
        );
    }

    public function show(Transmission $transmission): JsonResponse
    {
        return $this->success(
            data: TransmissionDetailsResource::make($transmission),
        );
    }
}
