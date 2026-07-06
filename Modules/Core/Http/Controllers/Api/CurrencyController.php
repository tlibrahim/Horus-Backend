<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\CurrencyServiceInterface;
use Modules\Core\Http\Requests\StoreCurrencyRequest;
use Modules\Core\Http\Requests\UpdateCurrencyRequest;
use Modules\Core\Http\Requests\UpdateCurrencyStatusRequest;
use Modules\Core\Http\Resources\CurrencyDetailsResource;
use Modules\Core\Http\Resources\CurrencyOptionResource;
use Modules\Core\Http\Resources\CurrencyResource;
use Modules\Core\Models\Currency;

final class CurrencyController extends BaseApiController
{
    public function __construct(
        private readonly CurrencyServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: CurrencyResource::class,
        );
    }

    /**
     * Display currencies for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: CurrencyOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created currency.
     */
    public function store(
        StoreCurrencyRequest $request,
    ): JsonResponse {
        $currency = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: CurrencyDetailsResource::make($currency),
        );
    }

    /**
     * Display the specified currency.
     */
    public function show(
        Currency $currency,
    ): JsonResponse {
        return $this->success(
            data: CurrencyDetailsResource::make($currency),
        );
    }

    /**
     * Update the specified currency.
     */
    public function update(
        UpdateCurrencyRequest $request,
        Currency $currency,
    ): JsonResponse {
        $currency = $this->service->update(
            $currency,
            $request->validated(),
        );

        return $this->updated(
            data: CurrencyDetailsResource::make($currency),
        );
    }

    /**
     * Toggle the status of the specified currency.
     */
    public function toggleStatus(
        UpdateCurrencyStatusRequest $request,
        Currency $currency,
    ): JsonResponse {
        $currency = $this->service->toggleStatus(
            $currency,
            $request->boolean('is_active'),
        );

        return $this->updated(
            data: CurrencyDetailsResource::make($currency),
        );
    }

    /**
     * Remove the specified currency.
     */
    public function destroy(
        Currency $currency,
    ): JsonResponse {
        $this->service->delete($currency);

        return $this->deleted();
    }
}
