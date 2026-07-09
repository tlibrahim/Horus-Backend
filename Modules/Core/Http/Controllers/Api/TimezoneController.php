<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Core\Contracts\TimezoneServiceInterface;
use Modules\Core\Http\Requests\StoreTimezoneRequest;
use Modules\Core\Http\Requests\UpdateTimezoneRequest;
use Modules\Core\Http\Requests\UpdateTimezoneStatusRequest;
use Modules\Core\Http\Resources\TimezoneDetailsResource;
use Modules\Core\Http\Resources\TimezoneOptionResource;
use Modules\Core\Http\Resources\TimezoneResource;

final class TimezoneController extends BaseCrudController
{
    public function __construct(
        TimezoneServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return TimezoneResource::class;
    }

    protected function detailResource(): string
    {
        return TimezoneDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return TimezoneOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreTimezoneRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateTimezoneRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateTimezoneStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'timezone';
    }
}
