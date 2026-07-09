<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\EngineServiceInterface;
use Modules\Vehicle\Http\Requests\StoreEngineRequest;
use Modules\Vehicle\Http\Requests\UpdateEngineRequest;
use Modules\Vehicle\Http\Requests\UpdateEngineStatusRequest;
use Modules\Vehicle\Http\Resources\EngineDetailsResource;
use Modules\Vehicle\Http\Resources\EngineOptionResource;
use Modules\Vehicle\Http\Resources\EngineResource;

final class EngineController extends BaseCrudController
{
    public function __construct(
        EngineServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return EngineResource::class;
    }

    protected function detailResource(): string
    {
        return EngineDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return EngineOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreEngineRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateEngineRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateEngineStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'engine';
    }
}
