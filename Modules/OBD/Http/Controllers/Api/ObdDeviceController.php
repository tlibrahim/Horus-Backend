<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\OBD\Contracts\Services\ObdDeviceServiceInterface;
use Modules\OBD\Http\Requests\StoreObdDeviceRequest;
use Modules\OBD\Http\Requests\UpdateObdDeviceRequest;
use Modules\OBD\Http\Requests\UpdateObdDeviceStatusRequest;
use Modules\OBD\Http\Resources\ObdDeviceDetailsResource;
use Modules\OBD\Http\Resources\ObdDeviceOptionResource;
use Modules\OBD\Http\Resources\ObdDeviceResource;

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
