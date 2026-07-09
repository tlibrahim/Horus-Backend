<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\VehicleModelServiceInterface;
use Modules\Vehicle\Http\Requests\StoreVehicleModelRequest;
use Modules\Vehicle\Http\Requests\UpdateVehicleModelRequest;
use Modules\Vehicle\Http\Requests\UpdateVehicleModelStatusRequest;
use Modules\Vehicle\Http\Resources\VehicleModelDetailsResource;
use Modules\Vehicle\Http\Resources\VehicleModelOptionResource;
use Modules\Vehicle\Http\Resources\VehicleModelResource;

final class VehicleModelController extends BaseCrudController
{
    public function __construct(
        VehicleModelServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return VehicleModelResource::class;
    }

    protected function detailResource(): string
    {
        return VehicleModelDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return VehicleModelOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreVehicleModelRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateVehicleModelRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateVehicleModelStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'vehicleModel';
    }
}
