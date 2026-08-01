<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Contracts\Services\RoleServiceInterface;
use Modules\Auth\Http\Requests\Role\StoreRoleRequest;
use Modules\Auth\Http\Requests\Role\SyncRolePermissionsRequest;
use Modules\Auth\Http\Requests\Role\UpdateRoleRequest;
use Modules\Auth\Http\Requests\Role\UpdateRoleStatusRequest;
use Modules\Auth\Http\Resources\PermissionResource;
use Modules\Auth\Http\Resources\RoleOptionResource;
use Modules\Auth\Http\Resources\RoleResource;
use Modules\Auth\Models\Role;

final class RoleController extends BaseCrudController
{
    public function __construct(
        RoleServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return RoleResource::class;
    }

    protected function detailResource(): string
    {
        return RoleResource::class;
    }

    protected function optionResource(): string
    {
        return RoleOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreRoleRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateRoleRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateRoleStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'role';
    }

    public function permissions(Role $role): JsonResponse
    {
        return $this->success(
            data: PermissionResource::collection(
                $this->service->permissions($role),
            ),
        );
    }

    public function syncPermissions(
        SyncRolePermissionsRequest $request,
        Role $role,
    ): JsonResponse {
        $role = $this->service->syncPermissions(
            $role,
            $request->validated('permissions', []),
        );

        return $this->updated(
            data: [
                'role' => RoleResource::make($role),
                'permissions' => PermissionResource::collection(
                    $this->service->permissions($role),
                ),
            ],
        );
    }
}
