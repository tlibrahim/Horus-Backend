<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\Catalog;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\Generation\GenerationServiceInterface;
use Modules\Vehicle\Http\Requests\Generation\StoreGenerationRequest;
use Modules\Vehicle\Http\Requests\Generation\UpdateGenerationRequest;
use Modules\Vehicle\Http\Requests\Generation\UpdateGenerationStatusRequest;
use Modules\Vehicle\Http\Resources\Generation\GenerationDetailsResource;
use Modules\Vehicle\Http\Resources\Generation\GenerationOptionResource;
use Modules\Vehicle\Http\Resources\Generation\GenerationResource;

final class GenerationController extends BaseCrudController
{
    public function __construct(
        GenerationServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return GenerationResource::class;
    }

    protected function detailResource(): string
    {
        return GenerationDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return GenerationOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreGenerationRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateGenerationRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateGenerationStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'generation';
    }
}
