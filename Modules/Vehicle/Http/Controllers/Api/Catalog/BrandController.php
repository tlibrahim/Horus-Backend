<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Controllers\Api\Catalog;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Vehicle\Contracts\Brand\BrandServiceInterface;
use Modules\Vehicle\Http\Requests\Brand\StoreBrandRequest;
use Modules\Vehicle\Http\Requests\Brand\UpdateBrandRequest;
use Modules\Vehicle\Http\Requests\Brand\UpdateBrandStatusRequest;
use Modules\Vehicle\Http\Resources\Brand\BrandDetailsResource;
use Modules\Vehicle\Http\Resources\Brand\BrandOptionResource;
use Modules\Vehicle\Http\Resources\Brand\BrandResource;

final class BrandController extends BaseCrudController
{
    public function __construct(
        BrandServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return BrandResource::class;
    }

    protected function detailResource(): string
    {
        return BrandDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return BrandOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreBrandRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateBrandRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateBrandStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'brand';
    }
}
