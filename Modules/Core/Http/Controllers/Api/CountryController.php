<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\CountryServiceInterface;
use Modules\Core\Http\Requests\StoreCountryRequest;
use Modules\Core\Http\Requests\UpdateCountryRequest;
use Modules\Core\Http\Requests\UpdateCountryStatusRequest;
use Modules\Core\Http\Resources\CountryDetailsResource;
use Modules\Core\Http\Resources\CountryOptionResource;
use Modules\Core\Http\Resources\CountryResource;
use Modules\Core\Models\Country;

final class CountryController extends BaseApiController
{
    public function __construct(
        private readonly CountryServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: CountryResource::class,
        );
    }

    /**
     * Display countries for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: CountryOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created country.
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        $country = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: CountryDetailsResource::make($country),
        );
    }

    /**
     * Display the specified country.
     */
    public function show(Country $country): JsonResponse
    {
        return $this->success(
            data: CountryDetailsResource::make($country),
        );
    }

    /**
     * Update the specified country.
     */
    public function update(
        UpdateCountryRequest $request,
        Country $country,
    ): JsonResponse {
        $country = $this->service->update(
            $country,
            $request->validated(),
        );

        return $this->success(
            data: CountryDetailsResource::make($country),
        );
    }

    /**
     * Toggle the status of the specified country.
     */
    public function toggleStatus(
        UpdateCountryStatusRequest $request,
        Country $country,
    ): JsonResponse {
        $country = $this->service->toggleStatus(
            $country,
            $request->boolean('is_active'),
        );

        return $this->success(
            data: CountryResource::make($country),
        );
    }

    /**
     * Remove the specified country.
     */
    public function destroy(Country $country): JsonResponse
    {
        $this->service->delete($country);

        return $this->deleted();
    }
}
