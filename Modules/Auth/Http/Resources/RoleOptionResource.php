<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Auth\Models\Role;

/** @mixin Role */
final class RoleOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
        ];
    }
}
