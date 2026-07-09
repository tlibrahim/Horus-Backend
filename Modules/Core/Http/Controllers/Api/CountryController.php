<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Core\Contracts\CountryServiceInterface;
use Modules\Core\Http\Requests\StoreCountryRequest;
use Modules\Core\Http\Requests\UpdateCountryRequest;
use Modules\Core\Http\Requests\UpdateCountryStatusRequest;
use Modules\Core\Http\Resources\CountryDetailsResource;
use Modules\Core\Http\Resources\CountryOptionResource;
use Modules\Core\Http\Resources\CountryResource;

final class CountryController extends BaseCrudController
{
    public function __construct(
        CountryServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return CountryResource::class;
    }

    protected function detailResource(): string
    {
        return CountryDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return CountryOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreCountryRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateCountryRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateCountryStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'country';
    }
}
