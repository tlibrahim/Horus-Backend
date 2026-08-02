<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\FeatureFlags\Services\FeatureFlagServiceInterface;
use Modules\Core\Http\Requests\FeatureFlags\StoreFeatureFlagRequest;
use Modules\Core\Http\Requests\FeatureFlags\UpdateFeatureFlagRequest;
use Modules\Core\Http\Resources\FeatureFlags\FeatureFlagResource;
use Modules\Core\Models\FeatureFlag;

final class FeatureFlagController extends BaseApiController
{
    public function __construct(
        private readonly FeatureFlagServiceInterface $features,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->features->paginate(),
            resource: FeatureFlagResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: $this->features->options(),
        );
    }

    public function show(
        FeatureFlag $featureFlag,
    ): JsonResponse {
        return $this->success(
            data: new FeatureFlagResource($featureFlag),
        );
    }

    public function store(
        StoreFeatureFlagRequest $request,
    ): JsonResponse {

        $featureFlag = $this->features->create(
            $request->validated(),
        );

        return $this->created(
            data: new FeatureFlagResource($featureFlag),
        );
    }

    public function update(
        UpdateFeatureFlagRequest $request,
        FeatureFlag $featureFlag,
    ): JsonResponse {

        $featureFlag = $this->features->update(
            $featureFlag,
            $request->validated(),
        );

        return $this->success(
            data: new FeatureFlagResource($featureFlag),
        );
    }

    public function destroy(
        FeatureFlag $featureFlag,
    ): JsonResponse {

        $this->features->delete($featureFlag);

        return $this->deleted();
    }

    /*
    |--------------------------------------------------------------------------
    | Business Endpoints
    |--------------------------------------------------------------------------
    */

    public function byKey(
        string $key,
    ): JsonResponse {

        $featureFlag = $this->features->findByKey($key);

        abort_if($featureFlag === null, 404);

        return $this->success(
            data: new FeatureFlagResource($featureFlag),
        );
    }

    public function enabled(): JsonResponse
    {
        return $this->success(
            data: FeatureFlagResource::collection(
                $this->features->enabled(),
            ),
        );
    }

    public function disabled(): JsonResponse
    {
        return $this->success(
            data: FeatureFlagResource::collection(
                $this->features->disabled(),
            ),
        );
    }

    public function enable(
        FeatureFlag $featureFlag,
    ): JsonResponse {

        return $this->success(
            data: new FeatureFlagResource(
                $this->features->enable($featureFlag->key),
            ),
        );
    }

    public function disable(
        FeatureFlag $featureFlag,
    ): JsonResponse {

        return $this->success(
            data: new FeatureFlagResource(
                $this->features->disable($featureFlag->key),
            ),
        );
    }
}
