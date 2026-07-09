<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\GenerationServiceInterface;
use Modules\Vehicle\Http\Requests\StoreGenerationRequest;
use Modules\Vehicle\Http\Requests\UpdateGenerationRequest;
use Modules\Vehicle\Http\Requests\UpdateGenerationStatusRequest;
use Modules\Vehicle\Http\Resources\GenerationDetailsResource;
use Modules\Vehicle\Http\Resources\GenerationOptionResource;
use Modules\Vehicle\Http\Resources\GenerationResource;

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
