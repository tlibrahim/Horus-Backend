<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\DistrictServiceInterface;
use Modules\Core\Http\Requests\StoreDistrictRequest;
use Modules\Core\Http\Requests\UpdateDistrictRequest;
use Modules\Core\Http\Requests\UpdateDistrictStatusRequest;
use Modules\Core\Http\Resources\DistrictDetailsResource;
use Modules\Core\Http\Resources\DistrictOptionResource;
use Modules\Core\Http\Resources\DistrictResource;
use Modules\Core\Models\District;

final class DistrictController extends BaseApiController
{
    public function __construct(
        private readonly DistrictServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: DistrictResource::class,
        );
    }

    /**
     * Display districts for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: DistrictOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created district.
     */
    public function store(
        StoreDistrictRequest $request,
    ): JsonResponse {
        $district = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: DistrictDetailsResource::make($district),
        );
    }

    /**
     * Display the specified district.
     */
    public function show(
        District $district,
    ): JsonResponse {
        return $this->success(
            data: DistrictDetailsResource::make($district),
        );
    }

    /**
     * Update the specified district.
     */
    public function update(
        UpdateDistrictRequest $request,
        District $district,
    ): JsonResponse {
        $district = $this->service->update(
            $district,
            $request->validated(),
        );

        return $this->updated(
            data: DistrictDetailsResource::make($district),
        );
    }

    /**
     * Toggle the status of the specified district.
     */
    public function toggleStatus(
        UpdateDistrictStatusRequest $request,
        District $district,
    ): JsonResponse {
        $district = $this->service->toggleStatus(
            $district,
            $request->boolean('is_active'),
        );

        return $this->updated(
            data: DistrictDetailsResource::make($district),
        );
    }

    /**
     * Remove the specified district.
     */
    public function destroy(
        District $district,
    ): JsonResponse {
        $this->service->delete($district);

        return $this->deleted();
    }
}
