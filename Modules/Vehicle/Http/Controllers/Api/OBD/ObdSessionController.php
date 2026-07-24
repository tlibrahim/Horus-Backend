<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\OBD;

use App\Support\Http\Controllers\BaseCrudController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\OBD\Services\ObdSessionServiceInterface;
use Modules\Vehicle\Http\Requests\OBD\Sessions\StoreObdSessionRequest;
use Modules\Vehicle\Http\Requests\OBD\Sessions\UpdateObdSessionRequest;
use Modules\Vehicle\Http\Requests\OBD\Sessions\UpdateObdSessionStatusRequest;
use Modules\Vehicle\Http\Resources\OBD\Sessions\ObdSessionDetailsResource;
use Modules\Vehicle\Http\Resources\OBD\Sessions\ObdSessionOptionResource;
use Modules\Vehicle\Http\Resources\OBD\Sessions\ObdSessionResource;
use Modules\Vehicle\Models\ObdSession;
use Modules\Vehicle\Models\VehicleObdDevice;

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
