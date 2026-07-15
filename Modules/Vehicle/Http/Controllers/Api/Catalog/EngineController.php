<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\Catalog;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\Engine\EngineServiceInterface;
use Modules\Vehicle\Http\Requests\Engine\StoreEngineRequest;
use Modules\Vehicle\Http\Requests\Engine\UpdateEngineRequest;
use Modules\Vehicle\Http\Requests\Engine\UpdateEngineStatusRequest;
use Modules\Vehicle\Http\Resources\Engine\EngineDetailsResource;
use Modules\Vehicle\Http\Resources\Engine\EngineOptionResource;
use Modules\Vehicle\Http\Resources\Engine\EngineResource;

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
