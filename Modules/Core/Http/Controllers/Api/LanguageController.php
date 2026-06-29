<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\LanguageServiceInterface;
use Modules\Core\Http\Requests\StoreLanguageRequest;
use Modules\Core\Http\Requests\UpdateLanguageRequest;
use Modules\Core\Http\Requests\UpdateLanguageStatusRequest;
use Modules\Core\Http\Resources\LanguageDetailsResource;
use Modules\Core\Http\Resources\LanguageOptionResource;
use Modules\Core\Http\Resources\LanguageResource;
use Modules\Core\Models\Language;

final class LanguageController extends BaseApiController
{
    public function __construct(
        private readonly LanguageServiceInterface $service,
    ) {}

    /**
     * Display a paginated listing.
     */
    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: LanguageResource::class,
        );
    }

    /**
     * Display languages for select inputs.
     */
    public function options(): JsonResponse
    {
        return $this->success(
            data: LanguageOptionResource::collection(
                $this->service->options(),
            ),
        );
    }

    /**
     * Store a newly created language.
     */
    public function store(
        StoreLanguageRequest $request,
    ): JsonResponse {
        $language = $this->service->create(
            $request->validated(),
        );

        return $this->created(
            data: LanguageDetailsResource::make($language),
        );
    }

    /**
     * Display the specified language.
     */
    public function show(
        Language $language,
    ): JsonResponse {
        return $this->success(
            data: LanguageDetailsResource::make($language),
        );
    }

    /**
     * Update the specified language.
     */
    public function update(
        UpdateLanguageRequest $request,
        Language $language,
    ): JsonResponse {
        $language = $this->service->update(
            $language,
            $request->validated(),
        );

        return $this->updated(
            data: LanguageDetailsResource::make($language),
        );
    }

    /**
     * Toggle the status of the specified language.
     */
    public function toggleStatus(
        UpdateLanguageStatusRequest $request,
        Language $language,
    ): JsonResponse {
        $language = $this->service->toggleStatus(
            $language,
            $request->boolean('is_active'),
        );

        return $this->updated(
            data: LanguageDetailsResource::make($language),
        );
    }

    /**
     * Remove the specified language.
     */
    public function destroy(
        Language $language,
    ): JsonResponse {
        $this->service->delete($language);

        return $this->deleted();
    }
}
