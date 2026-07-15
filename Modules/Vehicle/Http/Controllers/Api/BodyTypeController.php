<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\BodyType\BodyTypeServiceInterface;
use Modules\Vehicle\Http\Resources\BodyType\BodyTypeDetailsResource;
use Modules\Vehicle\Http\Resources\BodyType\BodyTypeOptionResource;
use Modules\Vehicle\Http\Resources\BodyType\BodyTypeResource;
use Modules\Vehicle\Models\BodyType;

final class BodyTypeController extends BaseApiController
{
    public function __construct(
        private readonly BodyTypeServiceInterface $service,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: BodyTypeResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: BodyTypeOptionResource::collection($this->service->options()),
        );
    }

    public function show(BodyType $bodyType): JsonResponse
    {
        return $this->success(
            data: BodyTypeDetailsResource::make($bodyType),
        );
    }
}
