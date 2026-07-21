<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\OBD;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\Vehicle\Contracts\OBD\Services\ObdDeviceServiceInterface;
use Modules\Vehicle\Contracts\OBD\Services\VehicleObdDeviceServiceInterface;
use Modules\Vehicle\Http\Requests\OBD\PairObdDeviceRequest;
use Modules\Vehicle\Http\Requests\OBD\UnpairObdDeviceRequest;
use Modules\Vehicle\Http\Resources\OBD\VehicleObdDeviceDetailsResource;
use Modules\Vehicle\Http\Resources\OBD\VehicleObdDeviceResource;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;

final class VehicleObdDeviceController extends BaseApiController
{
    public function __construct(
        private readonly VehicleObdDeviceServiceInterface $service,
        private readonly ObdDeviceServiceInterface $obdDevices,
    ) {}

    public function pair(
        PairObdDeviceRequest $request,
        Vehicle $vehicle,
    ): JsonResponse {
        $device = $this->obdDevices->find(
            $request->integer('obd_device_id'),
        );

        $pairing = $this->service->pair(
            $vehicle,
            $device,
            $request->validated(),
        );

        return $this->created(
            data: VehicleObdDeviceDetailsResource::make($pairing),
        );
    }

    public function unpair(
        UnpairObdDeviceRequest $request,
        Vehicle $vehicle,
        ObdDevice $obdDevice,
    ): JsonResponse {
        $pairing = $this->service->unpair(
            $vehicle,
            $obdDevice,
            $request->validated(),
        );

        return $this->updated(
            data: VehicleObdDeviceDetailsResource::make($pairing),
        );
    }

    public function current(
        Vehicle $vehicle,
    ): JsonResponse {
        $pairing = $this->service->current($vehicle);

        return $this->success(
            data: $pairing
                ? VehicleObdDeviceDetailsResource::make($pairing)
                : null,
        );
    }

    public function history(
        Vehicle $vehicle,
    ): JsonResponse {
        return $this->success(
            data: VehicleObdDeviceResource::collection(
                $this->service->history($vehicle),
            ),
        );
    }
}
