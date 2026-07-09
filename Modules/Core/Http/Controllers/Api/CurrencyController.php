<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Core\Contracts\CurrencyServiceInterface;
use Modules\Core\Http\Requests\StoreCurrencyRequest;
use Modules\Core\Http\Requests\UpdateCurrencyRequest;
use Modules\Core\Http\Requests\UpdateCurrencyStatusRequest;
use Modules\Core\Http\Resources\CurrencyDetailsResource;
use Modules\Core\Http\Resources\CurrencyOptionResource;
use Modules\Core\Http\Resources\CurrencyResource;

final class CurrencyController extends BaseCrudController
{
    public function __construct(
        CurrencyServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return CurrencyResource::class;
    }

    protected function detailResource(): string
    {
        return CurrencyDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return CurrencyOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreCurrencyRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateCurrencyRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateCurrencyStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'currency';
    }
}
