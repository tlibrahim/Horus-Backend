<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\OBD;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\OBD\Services\ObdDeviceServiceInterface;
use Modules\Vehicle\Http\Requests\OBD\StoreObdDeviceRequest;
use Modules\Vehicle\Http\Requests\OBD\UpdateObdDeviceRequest;
use Modules\Vehicle\Http\Requests\OBD\UpdateObdDeviceStatusRequest;
use Modules\Vehicle\Http\Resources\OBD\ObdDeviceDetailsResource;
use Modules\Vehicle\Http\Resources\OBD\ObdDeviceOptionResource;
use Modules\Vehicle\Http\Resources\OBD\ObdDeviceResource;

final class ObdDeviceController extends BaseCrudController
{
    public function __construct(
        ObdDeviceServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return ObdDeviceResource::class;
    }

    protected function detailResource(): string
    {
        return ObdDeviceDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return ObdDeviceOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreObdDeviceRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateObdDeviceRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateObdDeviceStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'obdDevice';
    }
}
