<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Auth\Contracts\Services\PermissionServiceInterface;
use Modules\Auth\Http\Requests\Permission\StorePermissionRequest;
use Modules\Auth\Http\Requests\Permission\UpdatePermissionRequest;
use Modules\Auth\Http\Resources\PermissionOptionResource;
use Modules\Auth\Http\Resources\PermissionResource;

final class PermissionController extends BaseCrudController
{
    public function __construct(
        PermissionServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return PermissionResource::class;
    }

    protected function detailResource(): string
    {
        return PermissionResource::class;
    }

    protected function optionResource(): string
    {
        return PermissionOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StorePermissionRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdatePermissionRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'permission';
    }
}
