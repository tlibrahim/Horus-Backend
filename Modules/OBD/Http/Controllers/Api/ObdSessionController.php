<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Illuminate\Http\JsonResponse;
use Modules\OBD\Contracts\Services\ObdSessionServiceInterface;
use Modules\OBD\Http\Requests\Sessions\StoreObdSessionRequest;
use Modules\OBD\Http\Requests\Sessions\UpdateObdSessionRequest;
use Modules\OBD\Http\Requests\Sessions\UpdateObdSessionStatusRequest;
use Modules\OBD\Http\Resources\Sessions\ObdSessionDetailsResource;
use Modules\OBD\Http\Resources\Sessions\ObdSessionOptionResource;
use Modules\OBD\Http\Resources\Sessions\ObdSessionResource;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

final class ObdSessionController extends BaseCrudController
{
    public function __construct(
        ObdSessionServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return ObdSessionResource::class;
    }

    protected function detailResource(): string
    {
        return ObdSessionDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return ObdSessionOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreObdSessionRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateObdSessionRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateObdSessionStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'obdSession';
    }

    /*
    |--------------------------------------------------------------------------
    | Session Lifecycle
    |--------------------------------------------------------------------------
    */

    public function connect(
        VehicleObdDevice $pairing,
    ): JsonResponse {

        $session = $this->service->startSession($pairing);

        return $this->created(
            data: ObdSessionDetailsResource::make($session),
        );
    }

    public function heartbeat(
        ObdSession $obdSession,
    ): JsonResponse {

        $session = $this->service->heartbeat($obdSession);

        return $this->updated(
            data: ObdSessionDetailsResource::make($session),
        );
    }

    public function disconnect(
        ObdSession $obdSession,
    ): JsonResponse {

        $session = $this->service->disconnectSession($obdSession);

        return $this->updated(
            data: ObdSessionDetailsResource::make($session),
        );
    }

    public function active(
        VehicleObdDevice $pairing,
    ): JsonResponse {

        $session = $this->service->activeForPairing($pairing);

        return $this->success(
            data: $session
                ? ObdSessionDetailsResource::make($session)
                : null,
        );
    }

    public function history(
        VehicleObdDevice $pairing,
    ): JsonResponse {

        return $this->success(
            data: ObdSessionResource::collection(
                $this->service->historyForPairing($pairing),
            ),
        );
    }
}
