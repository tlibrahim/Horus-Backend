<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\Transmission\TransmissionServiceInterface;
use Modules\Vehicle\Http\Resources\Transmission\TransmissionDetailsResource;
use Modules\Vehicle\Http\Resources\Transmission\TransmissionOptionResource;
use Modules\Vehicle\Http\Resources\Transmission\TransmissionResource;
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
