<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\TimezoneServiceInterface;
use Modules\Core\Http\Requests\StoreTimezoneRequest;
use Modules\Core\Http\Requests\UpdateTimezoneRequest;
use Modules\Core\Http\Requests\UpdateTimezoneStatusRequest;
use Modules\Core\Http\Resources\TimezoneDetailsResource;
use Modules\Core\Http\Resources\TimezoneOptionResource;
use Modules\Core\Http\Resources\TimezoneResource;
use Modules\Core\Models\Timezone;

final class TimezoneController extends BaseApiController
{
    public function __construct(
        private readonly TimezoneServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: TimezoneResource::class,
        );
    }

    /**
     * Display timezones for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: TimezoneOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created timezone.
     */
    public function store(
        StoreTimezoneRequest $request,
    ): JsonResponse {
        $timezone = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: TimezoneDetailsResource::make($timezone),
        );
    }

    /**
     * Display the specified timezone.
     */
    public function show(
        Timezone $timezone,
    ): JsonResponse {
        return $this->success(
            data: TimezoneDetailsResource::make($timezone),
        );
    }

    /**
     * Update the specified timezone.
     */
    public function update(
        UpdateTimezoneRequest $request,
        Timezone $timezone,
    ): JsonResponse {
        $timezone = $this->service->update(
            $timezone,
            $request->validated(),
        );

        return $this->updated(
            data: TimezoneDetailsResource::make($timezone),
        );
    }

    /**
     * Toggle the status of the specified timezone.
     */
    public function toggleStatus(
        UpdateTimezoneStatusRequest $request,
        Timezone $timezone,
    ): JsonResponse {
        $timezone = $this->service->toggleStatus(
            $timezone,
            $request->boolean('is_active'),
        );

        return $this->updated(
            data: TimezoneDetailsResource::make($timezone),
        );
    }

    /**
     * Remove the specified timezone.
     */
    public function destroy(
        Timezone $timezone,
    ): JsonResponse {
        $this->service->delete($timezone);

        return $this->deleted();
    }
}
