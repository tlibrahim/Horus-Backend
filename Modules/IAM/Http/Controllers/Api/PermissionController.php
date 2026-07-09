<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\IAM\Contracts\Services\PermissionServiceInterface;
use Modules\IAM\Http\Requests\Permission\StorePermissionRequest;
use Modules\IAM\Http\Requests\Permission\UpdatePermissionRequest;
use Modules\IAM\Http\Resources\PermissionOptionResource;
use Modules\IAM\Http\Resources\PermissionResource;

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
