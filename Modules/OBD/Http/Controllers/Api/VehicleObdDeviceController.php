<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Modules\OBD\Contracts\Services\ObdDeviceServiceInterface;
use Modules\OBD\Contracts\Services\VehicleObdDeviceServiceInterface;
use Modules\OBD\Http\Requests\PairObdDeviceRequest;
use Modules\OBD\Http\Requests\UnpairObdDeviceRequest;
use Modules\OBD\Http\Resources\VehicleObdDeviceDetailsResource;
use Modules\OBD\Http\Resources\VehicleObdDeviceResource;
use Modules\OBD\Models\ObdDevice;
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
