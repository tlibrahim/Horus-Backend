<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\CityServiceInterface;
use Modules\Core\Http\Requests\StoreCityRequest;
use Modules\Core\Http\Requests\UpdateCityRequest;
use Modules\Core\Http\Requests\UpdateCityStatusRequest;
use Modules\Core\Http\Resources\CityDetailsResource;
use Modules\Core\Http\Resources\CityOptionResource;
use Modules\Core\Http\Resources\CityResource;
use Modules\Core\Models\City;

final class CityController extends BaseApiController
{
    public function __construct(
        private readonly CityServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: CityResource::class,
        );
    }

    /**
     * Display cities for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: CityOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created city.
     */
    public function store(
        StoreCityRequest $request,
    ): JsonResponse {
        $city = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: CityDetailsResource::make($city),
        );
    }

    /**
     * Display the specified city.
     */
    public function show(
        City $city,
    ): JsonResponse {
        return $this->success(
            data: CityDetailsResource::make($city),
        );
    }

    /**
     * Update the specified city.
     */
    public function update(
        UpdateCityRequest $request,
        City $city,
    ): JsonResponse {
        $city = $this->service->update(
            $city,
            $request->validated(),
        );

        return $this->updated(
            data: CityDetailsResource::make($city),
        );
    }

    /**
     * Toggle the status of the specified city.
     */
    public function toggleStatus(
        UpdateCityStatusRequest $request,
        City $city,
    ): JsonResponse {
        $city = $this->service->toggleStatus(
            $city,
            $request->boolean('is_active'),
        );

        return $this->updated(
            data: CityDetailsResource::make($city),
        );
    }

    /**
     * Remove the specified city.
     */
    public function destroy(
        City $city,
    ): JsonResponse {
        $this->service->delete($city);

        return $this->deleted();
    }
}
