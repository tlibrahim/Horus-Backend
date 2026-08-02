<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Core\Contracts\Settings\Services\SettingServiceInterface;
use Modules\Core\Http\Requests\Settings\StoreSettingRequest;
use Modules\Core\Http\Requests\Settings\UpdateSettingRequest;
use Modules\Core\Http\Resources\Settings\SettingResource;
use Modules\Core\Models\Setting;

final class SettingController extends BaseApiController
{
    public function __construct(
        private readonly SettingServiceInterface $settings,
    ) {}

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->settings->paginate(),
            resource: SettingResource::class,
        );
    }

    public function options(): JsonResponse
    {
        return $this->success(
            data: $this->settings->options()
        );
    }

    public function show(
        Setting $setting,
    ): JsonResponse {
        return $this->success(
            data: new SettingResource($setting)
        );
    }

    public function store(
        StoreSettingRequest $request,
    ): JsonResponse {

        $setting = $this->settings->create(
            $request->validated()
        );

        return $this->created(
            data: new SettingResource($setting)
        );
    }

    public function update(
        UpdateSettingRequest $request,
        Setting $setting,
    ): JsonResponse {

        $setting = $this->settings->update(
            $setting,
            $request->validated(),
        );

        return $this->success(
            data: new SettingResource($setting)
        );
    }

    public function destroy(
        Setting $setting,
    ): JsonResponse {

        $this->settings->delete($setting);

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

        $setting = $this->settings->findByKey($key);

        abort_if($setting === null, 404);

        return $this->success(
            data: new SettingResource($setting)
        );
    }

    public function group(
        string $group,
    ): JsonResponse {

        return $this->success(
            data: SettingResource::collection(
                $this->settings->group($group)
            )
        );
    }
}
